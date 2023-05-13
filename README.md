# Library

## Folder explanations
- `www`: the website source itself (including index.php)
- `db`: saved database (modifying files inside my require root perms)
- `dock`: scripts used for building and running docker container

## Docker usage
**If your user isn't added to docker group you may need to run all docker commands as root (with sudo)!**
<br>
To start the website run: `docker compose up` (to stop the container press Crtl+C)
<br>
If you want to reset the database or you changed something in initdb.sql, dock folder or the Dockerfile you need to rebuild the container image.
<br>
To rebuild the image first remove files in db (`sudo rm -r db/*`) and then run: `docker compose build`
