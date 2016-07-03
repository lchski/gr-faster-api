Docker notes:

* `docker-compose up` starts the development environment (`-d` detaches from terminal)
* `docker-compose build` rebuilds the images to accept new source code
* `docker-compose -f docker-compose.yml -f docker-compose.prod.yml up` runs with production settings
    * Right now, “production settings” just means that it uses a different port (`8081`), but also that the source code is frozen---changing the code in `src/` won’t have effect until the images are rebuilt.

Links (temp):
* https://docs.docker.com/docker-hub/accounts/
* https://www.clay.fail/posts/hip-http2-using-docker/
* http://networkstatic.net/docker-one-liners/
* https://www.codeschool.com/blog/2015/01/16/production-deployment-docker/
* https://docs.docker.com/compose/compose-file/
* https://docs.docker.com/compose/production/
* https://developer.rackspace.com/blog/dev-to-deploy-with-docker-machine-and-compose/ and https://github.com/rackerlabs/guestbook
