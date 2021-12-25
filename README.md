<p  align="center">
<img src="https://raw.githubusercontent.com/anthonybudd/LaraChan/8.x/docs/img/larachan.png" width="200" alt="LaraChan Logo">
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
<img src="https://raw.githubusercontent.com/anthonybudd/LaraChan/8.x/docs/img/pi.png" width="500" alt="LaraChan Pi">
</p>

## Raspberry Pi Set-up
To set-up a Raspberry Pi server run the following commands.
```sh
// Docker
curl -fsSL https://get.docker.com -o get-docker.sh
sudo sh get-docker.sh
sudo groupadd docker
sudo usermod -aG docker $USER
sudo systemctl enable docker

// Docker-Compose
sudo apt-get install libffi-dev libssl-dev
sudo apt install python3-dev
sudo apt-get install -y python3 python3-pip
sudo pip3 install docker-compose




git clone git@github.com:anthonybudd/LaraChan.git

cd LaraChan

mv docker-compose.arm64.yml docker-compose.yml

// TOR
git clone git@github.com:anthonybudd/nginx-tor-proxy.git && cd nginx-tor-proxy
docker run -ti --entrypoint="mkp224o" -v $(pwd):/tor larachan_larachan-tor-proxy -n 1 -S 10 -d /tor [FILTER] 
mv *.onion web
chmod 700 web
sed -ie 's#xxxxx.onion#'"$(cat web/hostname)"'#g' nginx/tor.conf
cat web/hostname
cd ..

docker-compose build

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

Example
`php artisan larachan:create-board pol "Politically Incorrect"`

### $> larachan:delete-board
To delete a board 
`php artisan larachan:delete-board {boardName}`

### $> larachan:delete-thread
To delete a thread 
`php artisan larachan:delete-thread {uuid}`

### $> larachan:delete-reply
To delete a reply
`php artisan larachan:delete-reply {uuid}`

  
## Todo
LaraChan is still in active development. 

- Admin Interface
- IPFS integration
- API
- Tests
- Fix validation - [hacky solution atm](https://github.com/anthonybudd/LaraChan/blob/8.x/packages/LaraChan/Core/src/Http/Controllers/ThreadController.php#L60), Validator::make()->validate() never returning an error bag? Probable session or Tor issue.