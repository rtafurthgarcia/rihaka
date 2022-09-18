# rihaka

a website where you share ssh sessions caught on your honeypots

# dev environment setup
This is what you need to do in order to setup the dev environment

## 1. Install what's needed
In order to work on the project, you need to meet the following requirements:

- vscode
- docker
- this vs code extension installed : `ms-vscode-remote.remote-containers`

## 2. Clone everything
Good old `git clone git@github.com:rtafurthgarcia/rihaka.git` into your regular developpment folder

## 3. Adapt your database .env file
You need to rename the `config/Database.example.env` to `config/Database.env`

This one file contains all thats necessary to connect RIHAKA to its PostgreSQL database. You may change those credentials if you want to. Docker's gonna setup itself also through this one `.env` file so you won't have to duplicate those settings anywhere.

It may look inconvenient but it's likely we gonna keep the same sorta file for future deployments. 

## 4. Open the proper project
Simply open the project with VScode. After a few seconds, the following pop-up should appear in the lower-right corner of your screen:
![Imgur Image](https://i.imgur.com/iiJEIZG.png)

It may take also one or two minutes in order to setup everything. 

If such popup asks you to restart, plz obey and restart the whole thing. It's a required step in order to install all VScode extensions. 
Its also something you gonna do only (hopefully) once.
![Imgur Image](https://i.imgur.com/gS53dpo.png) 

## 5. Connect yourself to the database through SQLtools
In order to run tests on the database, and in order to idk explore it or execute queries quickly, you may rely on this one extension: 
`SQLTools`. 

It's very convenient and its quick to setup. All you need to do is to click "Add new connection" and to enter all the credentials from the previous `config/Database.env` file. 

![Imgur Image](https://i.imgur.com/56w6By8.png) 

## 6. Debug and run 
Normally in the meanwhile VScode should have already installed all extensions, PHP-related ones included. 
In order to test if the project works correctly, just press `F5` and let yourself be surprised :)

# Frameworks 

We use 4 main building blocks for our project:
 - [Slim PHP v4](https://www.slimframework.com/docs/v4/), to manage routing, exceptions, template generation and upload management
 - [Bootstrap v5](https://getbootstrap.com/docs/5.2/getting-started/introduction/), to quickly generate good-looking webpages through "class-styling"
 - [PostgreSQL v14](https://www.postgresql.org/docs/14/index.html), for the Database 
 - [asciinema-player v3](https://github.com/asciinema/asciinema-player), to play our SSH session recordings 

All links directly forward to their respective documentations, for quick access.