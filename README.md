# LaraChan
A simple 4chan-style imageboard built using Laravel.

- 🤖 **CAPTCHA** - Self-hosted captchas.
- 🚫 **No .JS** - Tor ready, no use of JavaScript.
- 🖥 **Laravel** - Built on Laravel 8.1
- 🤓 **Simple** - Simple data-structure and codebase

<p  align="center">
<img  width="500" src="https://raw.githubusercontent.com/anthonybudd/LaraChan/8.x/docs/img/screenshot.gif"  alt="Larachan ScreenShot">
</p>


## Getting Started
LaraChan can be installed in 4 easy commands. 

```sh
git clone git@github.com:anthonybudd/LaraChan.git

docker-compose up -d

php artisan larachan:install

php artisan serve
```
<sub><sup>⚠️ Hint: MySQL might take a miniute or so to initalize on first boot</sub></sup>

## Commands
LaraChan comes with some commands to make managing your imageboard easy.

### $> larachan:populate
To populate your instance with fake data run the command `php artisan larachan:populate`

### $> larachan:create-board
To create a new board run `php artisan larachan:create-board {boardName} {boardTitle} {about?}`

### $> larachan:delete-board
To populate your instance with fake data run the command `php artisan larachan:delete-board {boardName}`

### $> larachan:delete-thread
To populate your instance with fake data run the command `php artisan larachan:delete-thread {uuid}`

### $> larachan:delete-reply
To populate your instance with fake data run the command `php artisan larachan:delete-reply {uuid}`

  
## Todo
LaraChan is in active development and breaking changes might be introduced.

- Display validation errors (not working)
- Admin interface
- IPFS/TOR integration
- API
- Tests