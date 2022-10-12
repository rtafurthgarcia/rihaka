<div class="container px-4 py-4 py-md-5">

    <h2>Docker Cowrie Manual</h2>


    <li>To get started quickly and give Cowrie a try, run:</li>
    <div class="p-4 mb-4 bg-dark rounded-3">
        <code>$ docker run -p 2222:2222 cowrie/cowrie:latest</br></code>
        <code>$ ssh -p 2222 root@localhost</code>
    </div>
    <li>On Docker Hub: <a href="https://hub.docker.com/r/cowrie/cowrie">https://hub.docker.com/r/cowrie/cowrie</a></li>


    <li>Configuring Cowrie in Docker</li>
    </br>
    </br>
    <p>Cowrie in Docker can be configured using environment variables. The variables start with COWRIE then have the section name in capitals, followed by the stanza in capitals. An example is below to enable telnet support:</p>
    <div class="p-4 mb-4 bg-dark rounded-3">
        <code>COWRIE_TELNET_ENABLED=yes</code>
    </div>
    </br>
    </br>
    <p>Alternatively, Cowrie in Docker can use an etc volume to store configuration data. Create cowrie.cfg inside the etc volume with the following contents to enable telnet in your Cowrie Honeypot in Docker:</p>
    <div class="p-4 mb-4 bg-dark rounded-3">
        <code>[telnet]</br>enabled = yes</code>
    </div>
    </br>
    </br>
    <p><strong>Now you have setup your first own honeypot.</br> Have Fun with it! :) </strong></p>
</div>