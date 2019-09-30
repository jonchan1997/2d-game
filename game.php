<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Shark Attack!!</title>
    <h1>Shark Attack!!</h1>
    <style>
    	* { padding: 0; margin: 0; }
    	canvas { background: #2B65EC; display: block; margin: 0 auto; }
    </style>
</head>
<body>

<canvas id="gameBoard" width="500" height="350"></canvas>
<script>
class shark
{
    constructor(player = null)
    {
        this._player = player;
        this._dir = -1;
        this._x = 0;
        this._y = 0;
        this._width = 32;
        this._height = 32;
        this._health = 100;
        this._speed = 1;
        this._sharkImage = new Image;
        this._sharkLeft = './shark_left.png';
        this._sharkRight = './shark_right.png';
        this._active = false;
        this._timer = 0;
        this._i = 0;
    }
    //getter
    get x()
    {
        return this._x;
    }
    get y()
    {
        return this._y;
    }
    get speed()
    {
        return this._speed;
    }
    get health()
    {
        return this._health;
    }
    get dir()
    {
        return this._dir;
    }
    get image()
    {
        return this._sharkImage;
    }
    get active()
    {
        return this._active;
    }
    get i()
    {
        return this._i;
    }
    get width()
    {
        return this._width;
    }
    get height()
    {
        return this.height;
    }
    //setter
    set sharkImage(i)
    {
        if( i === 0)
        {
            this._sharkImage.src = this._sharkRight;
        }
        else if(i === 1)
        {
            this._sharkImage.src = this._sharkLeft;
        }
        
    }
    set i(i)
    {
        this._i = i;
    }
    set speed(s)
    {
        this._speed = s;
    }
    set x(x)
    {
        this._x = x;
    }
    set y(y)
    {
        this._y = y;
    }
    set health(health)
    {
        this._health = health;
    }
    //methods
    spawn()
    {
        this._active = true;
        this._health = 100;
        this._dir = Math.floor(Math.random() * Math.floor(2));
        this.sharkImage(this._dir);
        if(this._dir === 0)
        {
            this._x = 0;
        }
        else if( this._dir === 1)
        {
            this._x = this._player.map.width;
            
        }
        this._y = Math.floor(Math.random() * Math.floor(this._player.map.height));
    }
    bite()
    {
        //for destroying raft
    }
    swim()
    {
        this.bumpRaft();
        this.shiftMovement();
        if(this._health > 0)
        {
          switch(this._dir)
          {
            case 0:
                this._x += 1 * this._speed;
                break;
            case 1:
                 this._x -= 1 * this._speed;
                 break;
            default:
                break;
          } 
          /*
          if(this._player.raft.y > this._y)
          {
            this._y += 1;
          }
          else if(this._player.raft.y < this._y)
          {
            this._y -= 1;
          }
            */
          this.sharkImage(this._dir);
        }
    }

    shiftMovement()
    {
        var i;
        var decRoll = Math.floor(Math.random() * Math.floor(2));
        if(this._player.raft.y >  (this.y - 32))
        {
            this._y += 1;
        }
        else if((this._player.raft.y + this._player.raft.height)  < (this._y + 32))
        {
            this._y -= 1;
        }
        for(i = 0; i < this._player.sharkCount; i++ )
        {
            if(this._i !== i)
            {
                if((this._player.shark(i).x <= this._x) && ( this._x <= (this._player.shark(i).x + 16)) && (this._player.shark(i).y <= this._y) && ( this._y <= (this._player.shark(i).y + 16)))
                {
                    this.changeDir();    
                }
            }
        }
        if(this._x > (this._player.map.width + 32))
        {
            if(decRoll === 1)
            {
            this.changeDir();
            this._x = this._player.map.width + 16;
            }
            else
            {
            this._x = -16;
            }
            this._active = true;
        }
        else if((this._x) < -32 )
        {
            if(decRoll === 1)
            {
                this.changeDir();
                this._x = -16;
            }
            else
            {
                this._x = this._player.map.width + 16;
            }
            this._active = true;
        }
        
    }

    isShark(a, b)
    {
        var i;
        for(i = 0; i < this._player.sharkCount; i++ )
        {
            if(this._i !== i)
            {
                if((this._player.shark(i).x <= a) && ( a <= (this._player.shark(i).x + 32)) && (this._player.shark(i).y <= b) && ( b <= (this._player.shark(i).y + 32)))
                {
                    return true;    
                }
            }
        }
        return false;
    }

    bumpRaft()
    {
        if(((this._x >= this._player.raft.x) && (this._x <= (this._player.raft.x + this._player.raft.width))) && ((this._y >= this._player.raft.y) && (this._y <= (this._player.raft.y + this._player.raft.height))))
        {
            if(this._active === true)
            {
                this._player.health -= 5 * this._speed;
                this._player.raft.newSize = -1 * this._speed;
                this._active = false;
            }
            //this._player.alert(this._player.x + 150, this._player.y + 150, "-5", "#ce2029");
            this.changeDir();
        }
    }
    sharkImage(i)
    {
        if( i === 0)
        {
            this._sharkImage.src = this._sharkRight;
        }
        else if(i === 1)
        {
            this._sharkImage.src = this._sharkLeft;
        }
        
    }
    changeDir()
    {

        if(this._dir === 0)
        {
            this._dir = 1;
            this.sharkImage(this._dir);
        }
        else if(this._dir === 1)
        {
            this._dir = 0;
            this.sharkImage(this._dir);
        }
    }
};
class rock {
constructor(r = 1, player = null) 
{
    this._dir = player.face;
    this._x = player.x + (player.width/2);
    this._y = player.y + (player.height/2) -1;
    this._ds = player.speed;
    this._r = r;
    this._active = true;
    this._player = player;
    this._timer = 100;
}

//Getter
get x() 
{
    return this._x;
}

get y() 
{
    return this._y;
}

get r()
{
    return this._r;
}

get active()
{
    return this._active;
}

//Method
movement()
{
    if(this._active !== false)
    {
        switch(this._dir)
        {
            case 0:
                this._x += 1 * this._ds;
                break;
            case 1:
                this._x -= 1 * this._ds;
                break;
            case 2:
                this._y -= 1 * this._ds;
                break;
            case 3:
                this._y += 1 * this._ds;
                break;
            default:
                break;
        }
        if(this._timer > 0)
        {
            this._timer -= 1;
        }
        else
        {
            this._active = false;
        }
    }
}

hit()
{
    if(this._dir !== null || this._dir !== -1)
    {
        if((this._x == this._player.map.width) || (this._y == this._player.map.height) || (this._x == 0) || (this._y == 0))
        {
            this._active = false;
        }
        if(this._player.sharkCount !== 0)
        {
            var i;
            for (i = 0; i < this._player.sharkCount; i++) 
            {
                if(this._player.shark(i).health > 0 && this._active === true)
                {
                    if(((this._player.shark(i).x - this._player.shark(i).width)  >= (this._x - this._r)) && ((this._player.shark(i).x + this._player.shark(i).width) <= (this._x + this._r)) && ((this._player.shark(i).y + this._player.shark(i).height) >= (this._y + this._r) ) && ((this._player.shark(i).y + this._player.shark(i).height) <= (this._y - this._r)))
                    {
                        this._player.shark(i).health -= 20;
                        if(this._player.shark(i).speed < 2)
                        {
                            this._player.shark(i).speed += 1;
                        }
                        if(this._player.shark(i).active === true)
                        {
                            this._player.shark(i).changeDir();
                        }
                        //this._player.alert(this._x + 150, this._y + 50, "-20", "#ce2029");
                        this._player.points += 1;
                        this._active = false;
                    }
                }
            }
        }
    }
}



};
class raft
{
    constructor(player = null)
    {
        this._player = player;
        this._raftHeight = 50;
        this._raftWidth = 50;
        this._x = this._player.x;
        this._y = this._player.y;
        this._player.raft = this;
        this._floatDelay = 0;
    }

    //getter
    get height()
    {
        return this._raftHeight;
    }
    get width()
    {
        return this._raftWidth;
    }
    get area()
    {
        return (this._raftHeight * this._raftWidth);
    }
    get x()
    {
        return this._x;
    }
    get y()
    {
        return this._y;
    }
    //setter
    set newSize(x)
    {
        if((this._raftWidth > this._player.width && this._raftHeight > this._player.height)||  x > 0)
        {
            this._raftWidth += x;
            this._raftHeight += x;
        }
    }
    set height(y)
    {
        this._raftHeight = y;
    }
    set width(x)
    {
        this._raftWidth = x;
    }
    set x(x)
    {
        this._x = x;
    }
    set y(y)
    {
        this._y = y;
    }
    //method
    float()
    {
        //var randomX = Math.floor(Math.random() * (this._raftWidth - this._x)) + this._x;
        //var randomY = Math.floor(Math.random() * (this._raftHeight - this._y)) + this._y;
        if(this._floatDelay == 0)
        {
            var choice = Math.floor(Math.random() * Math.floor(5));
            switch(choice)
            {
                case 0:
                    this._y -= 1;
                    this._floatDelay = 10;
                    break;
                case 1:
                    this._x += 1;
                    this._floatDelay = 10;
                    break;
                case 2:
                    this._x -= 1;
                    this._floatDelay = 10;
                    break;
                case 3:
                    this._y += 1;
                    this._floatDelay = 10;
                    break;
                case 4:
                default:
                    this._floatDelay = 10;
                    break;
            }
            this.boundry();
        }
        else
        {
            this._floatDelay -= 1;
        }
        
    }
    boundry()
    {
        //looks at right wall
        if(this._x + this._raftWidth > this._player.map.width) 
        {
            this._x = this._player.map.width - this._raftWidth - 1;
        }

        //looks at top wall
        if(this._y + this._raftHeight > this._player.map.height) 
        {
            this._y = this._player.map.height - this._raftHeight - 1;
        } 

        //looks at left wall
        if (this._x < 0)
        {
            this._x = this._raftWidth;
        }

        //looks at bottom wall
        if (this._y < 0)
        {
            this._y = this._raftHeight;
        }
    }

};
class player 
{
    constructor(name = "player", radius = 10, speed = 1, face = 2, map = null, game = null, raft = null) 
    {   
        this._raft = raft;
        this._playerName = name;
        this._playerImage = new Image;
        this._playerImage.src = './user.png';
        this._playerRadius = radius;
        this._playerSpeed = speed;
        this._playerFace = face;
        this._action = -1;
        this._map = map;
        this._game = game;
        this._alive = true;
        this._map = map;
        this._playerHeight = 32;
        this._playerWidth = 32;
        this._playerX =  (this._map.width- this._playerWidth)/2;
        this._playerY =  (this._map.height- this._playerHeight)/2;
        this._rocks = [];
        this._sharks = [];
        this._rocks.length = 0;
        this._health = 100;
        this._points = 0;
        this._playerBuffer = 0;
        this._level = 1;
    }

    //Getter
    get height()
    {
        return this._playerHeight;
    }
    get width()
    {
        return this._playerWidth;
    }
    get image()
    {
        return this._playerImage;
    }
    get alive()
    {
        return this._alive;
    }
    get name() 
    {
        return this._playerName;
    }

    get action() 
    {
        return this._action;
    }

    get face() 
    {
        return this._playerFace;
    }

    get x() 
    {
        return this._playerX;
    }

    get y() 
    {
        return this._playerY;
    }

    get r() 
    {
        return this._playerRadius; 
        
    }
    get health()
    {
        return this._health;
    }

    get map()
    {
        if(this._map == null)
        {
            throw "error!";
        }
        return this._map;
    }
    get sharkCount()
    {
        return this._sharks.length;
    }
    get sharksAlive()
    {
        var i;
        var count = 0;
        if(this._sharks.length !== 0)
        {
            for (i = 0; i < this._sharks.length; i++) 
            {
                if(this._sharks[i].health > 0)
                {
                    count += 1;
                }
            }
        }
        if(count > 0)
        {
            return true;
        }
        else
        {
            return false;
        }
        
    }
    get rockSize()
    {
        return this._rocks.length;
    }
    get speed()
    {
        return this._playerSpeed;
    }
    get points()
    {
        return this._points;
    }
    get level()
    {
        return this._level;
    }
    get raft()
    {
        if(this._raft == null)
        {
            throw "error!";
        }
        return this._raft;
    }
    //setter
    set name(name = "player")
    {
        this._playerName = name;
    }

    set action(action = -1)
    {
        this._action = action;
    }
    set level(x)
    {
        this._level = x;
    }

    set r(radius = 10)
    {
        this._playerRadius = radius;
    }

    set x(x)
    {
        this._playerX = x;
    }

    set y(y)
    {
        this._playerY = y;
    }

    set speed(speed)
    {
        this._playerSpeed = speed;
    }

    set health(damage)
    {
        this._health = damage;
    }
    set map(map)
    {
        this._map = map;
    }
    set points(p)
    {
        this._points = p;
    }
    set height(h)
    {
        this._playerHeight = h;
    }
    set width(w)
    {
        this._playerWidth = w;
    }
    set raft(raft)
    {
        this._raft = raft;
    }
    set face(dir)
    {
        this._playerFace = dir;
    }
    //method
    levelUp()
    {
        this._level += 1;
        this._raft.newSize = 5;
        var i;
        if(this._sharks.length !== 0)
        {
            for (i = 0; i < this._sharks.length; i++) 
            {
                if(this._sharks[i].health > 0)
                {
                    this._sharks[i].spawn();
                }
            }
        }
        //this.newShark();
        
    }
    setFace()
    {
        if(this._action !== -1)
        {
            this._playerFace = this._action;
        }

    }
    newShark()
    {
        this._sharks.push(new shark( this));
        this._sharks[this._sharks.length - 1].spawn();
        this._sharks[this._sharks.length - 1].i = this._sharks.length - 1;
    }
    movement()
    {
        if(this._playerBuffer > 0)
        {
            this._playerBuffer -= 1;
            this._action = -1;
        }
        //player actions
        // -1:def 0-right 1-left 2-top 3-bottom 4-space else not PLAYER ACTIONS
        switch(this._action)
        {
            case 0:
                this._playerX += 1 * this._playerSpeed;
                this._playerFace = 0;
                break;
            case 1:
                this._playerX -= 1 * this._playerSpeed;
                this._playerFace = 1;
                break;
            case 2:
                this._playerY -= 1 * this._playerSpeed;
                this._playerFace = 2;
                break;
            case 3:
                this._playerY += 1 * this._playerSpeed;
                this._playerFace = 3;
                break;
            case 4:
                this._rocks.push(new rock(2, this));
                this._playerBuffer = this._playerRadius; 
                break;
            case -1:
            default:
                break;
        }
        this.boundry();
    }
    checkHealth()
    {
        if(this._health <= 0)
        {
            this._health = 0;
            this._alive = false;
        }
    }
    boundry()
    {
        //looks at right wall
        if(this._playerX > this._raft.x + this._raft.width - (this._playerWidth/2) + 2) 
        {
            this._health -= 10;
            this.checkHealth();
            this._playerX = this._raft.x + this._raft.width -(this._playerWidth/2);
            //this._alive = false;
        }

        //looks at bottom wall
        if(this._playerY >= this._raft.y + this._raft.height - (this._playerHeight/2)) 
        {
            this._health -= 10;
            this.checkHealth();
            this._playerY = this._raft.y + this._raft.height -this._playerHeight;
            //this._alive = false;
        } 

        //looks at left wall
        if (this._playerX < this._raft.x - (this._raft.width/2))
        {
            this._health -= 10;
            this.checkHealth();
            this._playerX = this._raft.x - (this._playerWidth/2);
            //this._alive = false;
        }

        //looks at top wall
        if (this._playerY <= this._raft.y - this._playerHeight)
        {
            this._health -= 10;
            this.checkHealth();
            this._playerY = this._raft.y - (this._playerHeight/2);
            //this._alive = false;
        }
    }
    rock(i)
    {
        if(this._rocks.length != 0)
        {
            return this._rocks[i];
        }
    }
    shark(i)
    {
        if(this._sharks.length != 0)
        {
            return this._sharks[i];
        }
    }
    handle()
    {
        var i;
        if(this._rocks.length !== 0)
        {
            for (i = 0; i < this._rocks.length; i++) 
            {
                if(this._rocks[i].active == true)
                {
                    this._rocks[i].movement();
                    this._rocks[i].hit();
                }
            }
        }
    }
    alert(x, y, text , color)
    {
        this._game.beginPath();
        this._game.fillStyle = color;
        this._game.font="bold 20px Arial";
        this._game.fillText(text, x, y);
        this._game.fill();
        this._game.closePath();
    }
    
};
var map = document.getElementById("gameBoard");
var game = map.getContext("2d");
var user = new player("player", 10, 1, 2, map, game);
user.raft = new raft(user);
user.newShark(); 
user.name = prompt("What is your name?");
/*if (JSON.parse(localStorage.getItem('player')) !== null) 
{
    var user = JSON.parse(localStorage.getItem('player'));
    user.map = map;
    var boat = user.raft;
}
else
{
    var user = new player("player", 10, 1, 2, map);
    var boat = new raft(user);
    user.name = prompt("What is your name?");
    //localStorage.setItem('player', JSON.stringify(user));
}*/
alert("Greetings " + user.name + "! You awake from a devasting plane crash in the ocean after being knocked unconscious. Quickly, you manage to assemble a makeshift raft from the wreckage and piece together a slingshot with a few rocks. Now it's time to fend against the sharks in these waters before you end up like the rest of the crew! ")
alert("Use the w,a,s,d to move around the raft.");
alert(" User the arrow keys to aim your rocks.");
alert("Use the f key to throw rocks at the sharks.");
alert("Careful you might want to watch your step!");

document.addEventListener("keydown", keyDownHandler, false);
document.addEventListener("keyup", keyUpHandler, false);

function keyDownHandler(e) 
    {
        switch(e.key)
        {
            case 'd':
                user.action = 0;
                user.setFace();
                break;
            case 'ArrowRight':
                user.face = 0;
                break;
            case 'a':
                user.action = 1;
                user.setFace();
                break;
            case 'ArrowLeft':
                user.face = 1;
                break;
            case 'w':
                user.action = 2;
                user.setFace();
                break;
            case 'ArrowUp':
                user.face = 2;
                break;
            case 's':
                user.action =3;
                user.setFace();
                break;
            case 'ArrowDown':
                user.face = 3;
                break;
            case 'f':
                user.action = 4;
                break;
            default:
                user.action = -1;
                break;


        }
    }
    function keyUpHandler(e) 
    {
        switch(e.key)
        {
            case 'ArrowRight':
                user.action = -1;
                break;
            case 'ArrowLeft':
                user.action = -1;
                break;
            case 'ArrowUp':
                user.action = -1;
                break;
            case 'ArrowDown':
                user.action = -1;
                break;
            case 'f':
                user.action = -1;
                break;
            default:
                user.action = -1;
                break;

        }
    }

    function drawRaft() 
    {
        game.beginPath();
        game.rect(user.raft.x, user.raft.y, user.raft.width, user.raft.height);
        game.fillStyle = "#c19a6b";
        game.fill();
        game.closePath();
        user.raft.float();
    }
    function drawPlayer() 
    {

        game.beginPath();
        //game.arc(user.x, user.y, user.r, 0, Math.PI*2);
        game.drawImage(user.image, user.x, user.y, user.width, user.height);
        game.fillStyle = "#ffe0bd";
        game.fill();
        game.closePath();
        user.movement();
        user.handle();
    }
    function drawSharks()
    {
        var i;
        if(user.sharkCount !== 0)
        {
            if(!(user.sharksAlive))
            {
                user.levelUp();
            }
            for (i = 0; i < user.sharkCount; i++) 
            {
                
                if(user.shark(i).health > 0)
                {
                    user.shark(i).swim();
                    game.beginPath();
                    game.drawImage(user.shark(i).image, user.shark(i).x, user.shark(i).y , 32, 32);
                    game.fillStyle = "#a9a9a9";
                    game.fill();
                    game.closePath();
                }
            }
        }

    }
    function drawRocks()
    {
        var i;
        if(user.rockSize !== 0)
        {
            for (i = 0; i < user.rockSize; i++) 
            {
                user.rock(i).hit();
                if(user.rock(i).active == true)
                {
                    game.beginPath();
                    game.arc(user.rock(i).x, user.rock(i).y, user.rock(i).r, 0, Math.PI*2);
                    game.fillStyle = "#a9a9a9";
                    game.fill();
                    game.closePath();
                }
            }
        }
    }
    function drawData()
    {
        var info = "User: " + user.name.toUpperCase() + " | Score: " + user. points + " | Health: " + user.health + " | Level: " + user.level;
        game.beginPath();
        game.fillStyle = "#000000";
        game.font="bold 20px Arial";
        game.fillText(info, 20, 20);
        game.fill();
        game.closePath();
    }
    function gameOver()
    {
        drawData();
        game.beginPath();
        game.fillStyle = "#000000";
        game.font="bold 50px Arial";
        game.fillText("GAME OVER!", ((map.height - 70) /2), ((map.width -70 )/2));
        game.fill();
        game.closePath();

    }
    function draw() 
    {
        if(user.health > 0)
        {
            game.clearRect(0, 0,map.width, map.height);//sweep
            drawSharks();
            drawRaft();
            drawPlayer();
            drawRocks();
            drawData();
        }
        else
        {
            game.clearRect(0, 0,map.width, map.height);//sweep
            gameOver();

        }
    }
    setInterval(draw, 20);
   

</script>

</body>
</html>