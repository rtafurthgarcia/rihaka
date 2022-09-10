# rihaka

a website where you share ssh sessions caught on your honeypots

# dev environment setup

In order to work on the project, you need to meet the following requirements:

- vscode
- docker
- this vs code extension installed : `ms-vscode-remote.remote-containers`

 after you checked out the project's sources, just open the regular folder, and when vscode asks you to open it in a remote container, just do it

```
![Imgur Image](https://i.imgur.com/iiJEIZG.png)
```

if there is a new version of the Dockerfile or docker-compose.yml, plz make sure to delete the dev container (generally called `qrihaka_php-dev_env_n`) first ofc.
