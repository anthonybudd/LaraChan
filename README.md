<p  align="center">
<img src="https://raw.githubusercontent.com/anthonybudd/LaraChan/8.x/docs/img/logo-long.png" width="200" alt="LaraChan Logo">
</p>

## LaraChan
A simple 4chan-style imageboard built on Laravel. 

- 🧅 **Tor** - Built in Tor proxy
- 🤖 **CAPTCHA** - Self-hosted captchas.
- 🚫 **No .JS** - No front-end JavaScript.
- 🖥 **Laravel** - Built on Laravel 8



## Getting Started
LaraChan can be installed in 5 easy commands. 

```sh
git clone git@github.com:anthonybudd/LaraChan.git

cd LaraChan

docker-compose up -d

php artisan larachan:install

php artisan serve
```
<sub><sup>⚠️ Hint: MySQL might take a miniute or so to initalize on first boot</sub></sup>

<p  align="center">
<img src="https://raw.githubusercontent.com/anthonybudd/LaraChan/8.x/docs/img/pi.png" width="300" alt="LaraChan Pi">
</p>

## Raspberry Pi Set-up
To set-up a Raspberry Pi server run the following commands.
```sh
git clone git@github.com:anthonybudd/LaraChan.git

cd LaraChan

mv docker-compose.yml.arm64 docker-compose.yml

docker-compose build

docker run -it --rm -v $(pwd)/.vol/tor:/web larachan_larachan-tor-proxy generate ^lc

docker run -it --rm -v $(pwd):/app larachan_larachan composer install

docker-compose up

docker exec -it larachan php artisan larachan:install --platform=pi
```

## Commands
LaraChan comes with some commands to make managing your imageboard easy.

### $> larachan:populate
To populate your instance with fake data run the command 
`php artisan larachan:populate`

### $> larachan:monitor
If you would like an automatically updating live view of all of the most popular threads on your imageboard use the command 
`php artisan larachan:monitor {--threads=5} {--replies=5}`

### $> larachan:boards
List all the current boards 
`php artisan larachan:boards`

### $> larachan:create-board
To create a new board run 
`php artisan larachan:create-board {boardName} {boardTitle} {about?}`

### $> larachan:delete-board
To populate your instance with fake data run the command 
`php artisan larachan:delete-board {boardName}`

### $> larachan:delete-thread
To populate your instance with fake data run the command 
`php artisan larachan:delete-thread {uuid}`

### $> larachan:delete-reply
To populate your instance with fake data run the command 
`php artisan larachan:delete-reply {uuid}`

  
## Todo
LaraChan is still in active development. 

- Admin Interface
- IPFS integration
- API
- Tests
- Fix validation - [hacky solution atm](https://github.com/anthonybudd/LaraChan/blob/8.x/packages/LaraChan/Core/src/Http/Controllers/ThreadController.php#L60), Validator::make()->validate() never returning an error bag? Probable session or Tor issue.