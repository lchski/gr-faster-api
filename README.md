Docker notes:

* `docker-compose up` starts the development environment (`-d` detaches from terminal)
* `docker-compose build` rebuilds the images to accept new source code
* `docker-compose -f docker-compose.yml -f docker-compose.prod.yml up` runs with production settings
    * Right now, “production settings” just means that it uses a different port (`8081`), but also that the source code is frozen---changing the code in `src/` won’t have effect until the images are rebuilt.
