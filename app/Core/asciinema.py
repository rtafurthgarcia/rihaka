#!/usr/bin/env python

"""
LICENSE
#######

Copyright (c) 2009-2019 Upi Tamminen, Michel Oosterhof

All rights reserved.

Redistribution and use in source and binary forms, with or without
modification, are permitted provided that the following conditions
are met:

* Redistributions of source code must retain the above copyright
  notice, this list of conditions and the following disclaimer.
* Redistributions in binary form must reproduce the above copyright
  notice, this list of conditions and the following disclaimer in the
  documentation and/or other materials provided with the distribution.
* The names of the author(s) may not be used to endorse or promote
  products derived from this software without specific prior written
  permission.

THIS SOFTWARE IS PROVIDED BY THE AUTHORS ''AS IS'' AND ANY EXPRESS OR
IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES
OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED.
IN NO EVENT SHALL THE AUTHORS BE LIABLE FOR ANY DIRECT, INDIRECT,
INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING,
BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED
AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY,
OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY
OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF
SUCH DAMAGE.
"""

import getopt
import json
import os
import struct
import sys

OP_OPEN, OP_CLOSE, OP_WRITE, OP_EXEC = 1, 2, 3, 4
TYPE_INPUT, TYPE_OUTPUT, TYPE_INTERACT = 1, 2, 3

COLOR_INTERACT = "\033[36m"
COLOR_INPUT = "\033[33m"
COLOR_RESET = "\033[0m"


def playlog(fd, settings):
    thelog = {}
    thelog["version"] = 1
    thelog["width"] = 80
    thelog["height"] = 24
    thelog["duration"] = 0.0
    thelog["command"] = "/bin/bash"
    thelog["title"] = "Cowrie Recording"
    theenv = {}
    theenv["TERM"] = "xterm256-color"
    theenv["SHELL"] = "/bin/bash"
    thelog["env"] = theenv
    stdout = []
    thelog["stdout"] = stdout

    ssize = struct.calcsize("<iLiiLL")

    currtty, prevtime, prefdir = 0, 0, 0
    sleeptime = 0.0

    color = None

    while 1:
        try:
            (op, tty, length, dir, sec, usec) = struct.unpack("<iLiiLL", fd.read(ssize))
            data = fd.read(length)
        except struct.error:
            break

        if currtty == 0:
            currtty = tty

        if str(tty) == str(currtty) and op == OP_WRITE:
            # the first stream seen is considered 'output'
            if prefdir == 0:
                prefdir = dir
            if dir == TYPE_INTERACT:
                color = COLOR_INTERACT
            elif dir == TYPE_INPUT:
                color = COLOR_INPUT
            if dir == prefdir:
                curtime = float(sec) + float(usec) / 1000000
                if prevtime != 0:
                    sleeptime = curtime - prevtime
                prevtime = curtime
                if settings["colorify"] and color:
                    sys.stdout.write(color)

                # rtrox: While playback works properly
                #        with the asciinema client, upload
                #        causes mangling of the data due to
                #        newlines being misinterpreted without
                #        carriage returns.
                data = data.replace(b"\n", b"\r\n").decode("UTF-8")

                thedata = [sleeptime, data]
                thelog["duration"] += sleeptime
                stdout.append(thedata)

                if settings["colorify"] and color:
                    sys.stdout.write(COLOR_RESET)
                    color = None

        elif str(tty) == str(currtty) and op == OP_CLOSE:
            break

    if settings["output"] == "":
        json.dump(thelog, sys.stdout, indent=4)
    else:
        with open(settings["output"], "w") as outfp:
            json.dump(thelog, outfp, indent=4)


def help(verbose=False):
    print(
        "usage: %s [-c] [-o output] <tty-log-file> <tty-log-file>..."
        % os.path.basename(sys.argv[0])
    )

    if verbose:
        print(
            "  -c             colorify the output based on what streams are being received"
        )
        print("  -h             display this help")
        print("  -o             write to the specified output file")


if __name__ == "__main__":
    settings = {"colorify": 0, "output": ""}

    try:
        optlist, args = getopt.getopt(sys.argv[1:], "hco:")
    except getopt.GetoptError as error:
        sys.stderr.write("{}: {}\n".format(sys.argv[0], error))
        help()
        sys.exit(1)

    for o, a in optlist:
        if o == "-h":
            help()
        if o == "-c":
            settings["colorify"] = True
        if o == "-o":
            settings["output"] = a

    if len(args) < 1:
        help()
        sys.exit(2)

    for logfile in args:
        try:
            logfd = open(logfile, "rb")
            playlog(logfd, settings)
        except OSError as e:
            sys.stderr.write("{}: {}\n".format(sys.argv[0], e))
