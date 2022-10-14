<div class="container px-4 py-4 py-md-5">

    <h2>Old School Cowrie Manual</h2>

    <h3>Step 1: Install system dependencies</h3>
    <p>First we install system-wide support for Python virtual environments and other dependencies. Actual Python packages are installed later.</p>
    <div class="p-4 mb-4 bg-dark rounded-3">
        <code>sudo apt-get install git python3-virtualenv libssl-dev libffi-dev build-essential libpython3-dev python3-minimal authbind virtualenv</br></code>
    </div>
    <h3>Step 2: Create a user account</h3>
    <p>It’s strongly recommended to run with a dedicated non-root user id:</p>
    <div class="p-4 mb-4 bg-dark rounded-3">
        <code>$ sudo adduser --disabled-password cowrie</br>
            Adding user 'cowrie' ...</br>
            Adding new group 'cowrie' (1002) ...</br>
            Adding new user 'cowrie' (1002) with group 'cowrie' ...</br>
            Changing the user information for cowrie</br>
            Enter the new value, or press ENTER for the default</br>
            Full Name []:</br>
            Room Number []:</br>
            Work Phone []:</br>
            Home Phone []:</br>
            Other []:</br>
            Is the information correct? [Y/n]</br>
            $ sudo su - cowrie</br></code>
    </div>

    <h3>Step 3: Checkout the code</h3>
    <p>Check out the code:</p>
    <div class="p-4 mb-4 bg-dark rounded-3">
        <code>$ git clone http://github.com/cowrie/cowrie</br>
            Cloning into 'cowrie'...</br>
            remote: Counting objects: 2965, done.</br>
            remote: Compressing objects: 100% (1025/1025), done.</br>
            remote: Total 2965 (delta 1908), reused 2962 (delta 1905), pack-reused 0</br>
            Receiving objects: 100% (2965/2965), 3.41 MiB | 2.57 MiB/s, done.</br>
            Resolving deltas: 100% (1908/1908), done.</br>
            Checking connectivity... done.</br>

            $ cd cowrie</code>
    </div>

    <h3>Step 4: Setup Virtual Environment</h3>
    <p>Next you need to create your virtual environment:</p>
    <div class="p-4 mb-4 bg-dark rounded-3">
        <code>$ pwd</br>
/home/cowrie/cowrie</br>
$ virtualenv --python=python3 cowrie-env</br>
New python executable in ./cowrie/cowrie-env/bin/python</br>
Installing setuptools, pip, wheel...done.</code>
    </div>
    <p>Activate the virtual environment and install packages:</p>
    <div class="p-4 mb-4 bg-dark rounded-3">
        <code>$ source cowrie-env/bin/activate</br>
(cowrie-env) $ pip install --upgrade pip</br>
(cowrie-env) $ pip install --upgrade -r requirements.txt</code>
    </div>

    <h3>Step 5: Install configuration file</h3>
    <p>The configuration for Cowrie is stored in cowrie.cfg.dist and cowrie.cfg (Located in cowrie/etc). Both files are read on startup, where entries from cowrie.cfg take precedence. The .dist file can be overwritten by upgrades, cowrie.cfg will not be touched. To run with a standard configuration, there is no need to change anything. To enable telnet, for example, create cowrie.cfg and input only the following:</p>
    <div class="p-4 mb-4 bg-dark rounded-3">
        <code>[telnet]</br>
enabled = true</code>
    </div>
    <h3>Step 6: Starting Cowrie</h3>
    <p>Start Cowrie with the cowrie command. You can add the cowrie/bin directory to your path if desired. An existing virtual environment is preserved if activated, otherwise Cowrie will attempt to load the environment called “cowrie-env”:</p>
    <div class="p-4 mb-4 bg-dark rounded-3">
        <code>$ bin/cowrie start</br>
Activating virtualenv "cowrie-env"</br>
Starting cowrie with extra arguments [] ...</code>
    </div>
    <h3>Step 7: Listening on port 22 (OPTIONAL)</h3>
    <p>There are three methods to make Cowrie accessible on the default SSH port (22): iptables, authbind and setcap.</br>

<strong>Iptables</strong></br>
Port redirection commands are system-wide and need to be executed as root. A firewall redirect can make your existing SSH server unreachable, remember to move the existing server to a different port number first.</br>

The following firewall rule will forward incoming traffic on port 22 to port 2222 on Linux:</p>
    <div class="p-4 mb-4 bg-dark rounded-3">
        <code>$ sudo iptables -t nat -A PREROUTING -p tcp --dport 22 -j REDIRECT --to-port 2222</code>
    </div>
<p>Or for telnet:</p>
<div class="p-4 mb-4 bg-dark rounded-3">
        <code>$ sudo iptables -t nat -A PREROUTING -p tcp --dport 23 -j REDIRECT --to-port 2223</code>
    </div>
    <p>Note that you should test this rule only from another host; it doesn’t apply to loopback connections.</br>
On MacOS run:</p>
<div class="p-4 mb-4 bg-dark rounded-3">
        <code>echo "rdr pass inet proto tcp from any to any port 22 -> 127.0.0.1 port 2222" | sudo pfctl -ef -</code>
    </div>
    <strong>Authbind</strong></br>
    <p>Alternatively you can run authbind to listen as non-root on port 22 directly:</p>
    <div class="p-4 mb-4 bg-dark rounded-3">
        <code>$ sudo apt-get install authbind</br>
$ sudo touch /etc/authbind/byport/22</br>
$ sudo chown cowrie:cowrie /etc/authbind/byport/22</br>
$ sudo chmod 770 /etc/authbind/byport/22</code>
    </div>
    <p>Edit bin/cowrie and modify the AUTHBIND_ENABLED setting</br>

Change the listening port to 22 in cowrie.cfg:</p>

<div class="p-4 mb-4 bg-dark rounded-3">
        <code>[ssh]</br>
listen_endpoints = tcp:22:interface=0.0.0.0</code>
    </div>
    <p>Or for telnet:
    </p>
    <div class="p-4 mb-4 bg-dark rounded-3">
        <code>$ apt-get install authbind</br>
$ sudo touch /etc/authbind/byport/23</br>
$ sudo chown cowrie:cowrie /etc/authbind/byport/23</br>
$ sudo chmod 770 /etc/authbind/byport/23
</code>
    </div>
    <p>Change the listening port to 23 in cowrie.cfg:</p>
    <div class="p-4 mb-4 bg-dark rounded-3">
        <code>[telnet]</br>
listen_endpoints = tcp:2223:interface=0.0.0.0
</code>
    </div>
    </br>
    </br>
    <p><strong>Now you have setup your first own honeypot.</br> Have Fun with it! :) </strong></p>
</div>