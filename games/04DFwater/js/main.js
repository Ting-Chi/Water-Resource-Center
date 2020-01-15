var Boot = {
 preload: function() {
   game.load.image('preload', 'assets/preload.png');
 },
  
 create: function() {
   //視窗調整程式
   game.scale.scaleMode = Phaser.ScaleManager.SHOW_ALL;
   game.scale.pageAlignHorizontally = true;
   game.scale.pageAlignVertically = true;
   
   game.input.maxPointers = 1;
   game.state.start('Preloader');
 },
};

var Preloader = {
  ready: false,  
  preload: function() {
    this.preloadBar = game.add.sprite(game.width/2, game.height/2, 'preload');
    this.preloadBar.anchor.setTo(0.5, 0.5);
    game.load.setPreloadSprite(this.preloadBar);
    game.load.image('car', 'assets/car.png');
    game.load.image('car2', 'assets/car2.png');
    game.load.image('finally', 'assets/finally.png');
    game.load.image('space', 'assets/space.png');
    game.load.image('space2', 'assets/space2.png');
    game.load.image('levelup', 'assets/levelup.png');
    game.load.image('startbg', 'assets/startbg.png');
    game.load.image('go', 'assets/go.png');
    game.load.image('set', 'assets/set.png');
    game.load.image('setbg','assets/setbg.png');
    game.load.image('set01','assets/set01.png');
    game.load.image('endbg','assets/endbg.jpg'); 
    game.load.image('lostbg','assets/lostbg.jpg'); 
    game.load.image('again','assets/again.png');   
    game.load.image('mazeTiles', 'assets/tiles.png');
    game.load.image('choosebg','assets/choosebg.png');
    game.load.image('choosebg1','assets/choosebg1.png');
    game.load.image('choosebg2','assets/choosebg2.png');
    game.load.tilemap('map', 'assets/maze.json', null, Phaser.Tilemap.TILED_JSON);
    game.load.spritesheet('monster', 'assets/monster.png');
    game.load.spritesheet('up', 'assets/up.png');
    game.load.spritesheet('down', 'assets/down.png');
    game.load.spritesheet('left', 'assets/left.png');
    game.load.spritesheet('right', 'assets/right.png');
    game.load.spritesheet('goback', 'assets/goback.png');  
    game.load.audio('mainbgm', 'assets/mainbgm.mp3');
    game.load.audio('titlebgm', 'assets/titlebgm.mp3');
    game.load.audio('winbgm', 'assets/winbgm.mp3'); 
    game.load.audio('yes', 'assets/yes.mp3'); 
    game.load.audio('no', 'assets/no.mp3'); 
    game.load.audio('kill', 'assets/kill.mp3'); 
    game.load.audio('eatmonster', 'assets/eatmonster.mp3'); 
    game.load.audio('level', 'assets/level.mp3'); 
    game.load.audio('lostbgm', 'assets/lostbgm.mp3'); 
  },
  
  update: function() {
    // Make sure all mp3s have been decoded before starting the game
    if (this.ready) {
      return;
    } else if (game.cache.isSoundDecoded('mainbgm') &&
        game.cache.isSoundDecoded('titlebgm') &&
        game.cache.isSoundDecoded('winbgm')&&
        game.cache.isSoundDecoded('yes')&&
        game.cache.isSoundDecoded('no')&&
        game.cache.isSoundDecoded('kill')&&
        game.cache.isSoundDecoded('eatmonster')&&
        game.cache.isSoundDecoded('level')&&
        game.cache.isSoundDecoded('lostbgm')) {
      this.ready = true;
      game.state.start('titleScreen');
    }    
  },
};

var main = { 
  k:0,
  a:0, 
  life:3, 
  lifeText: null,
  mainbgm: null,
  create: function() {
    //音樂
    mainbgm = game.add.audio('mainbgm');
    mainbgm.play();
    //預設值
    this.k=0;
    this.a=0;     
    this.safeTileIndex = 1;
    this.gridsize = 32;
    this.speed = 300;
    this.threshold = 50;    
    this.gridPos = new Phaser.Point();
    this.turnPoint = new Phaser.Point();        
    this.fourTiles = [null, null, null, null, null];
    this.opposites = [Phaser.NONE, Phaser.RIGHT, Phaser.LEFT, Phaser.DOWN, Phaser.UP];
    this.currentDir = null;       
    //物理
    game.physics.startSystem(Phaser.Physics.ARCADE);
    //背景
    this.map = game.add.tilemap('map');
    this.map.addTilesetImage('tiles', 'mazeTiles');
    this.layer = this.map.createLayer('Tile Layer 1');
    this.map.setCollision(20, true, this.layer);
    //終點遮罩    
    this.space = game.add.sprite(352, 416, 'space');
    game.physics.arcade.enable(this.space);
    //主角
    this.car = game.add.sprite(48, 48, 'car');
    this.car.anchor.set(0.5);
    game.physics.arcade.enable(this.car);       
    //點擊
    this.cursors = game.input.onDown.add(this.onDown, this);
    //藥水
    this.levelup = game.add.sprite(32, 544, 'levelup');
    game.physics.arcade.enable(this.levelup);
    //字體
    var style = {
     font: '30px 微軟正黑體',
     fill: '#37281c',
     align: 'center'     
    }
    //顯示生命
    this.space2 = game.add.sprite(320, 0, 'space2');
    this.lifeText = game.add.text(322, 16, '　　' + this.life, style);     
    //怪物    
    this.monster1 = game.add.sprite(32, 96, 'monster');
    this.monster2 = game.add.sprite(352, 224, 'monster');
    this.monster3 = game.add.sprite(96, 288, 'monster');
    this.monster4 = game.add.sprite(346, 480, 'monster');    
    
    game.physics.arcade.enable(this.monster1);
    game.physics.arcade.enable(this.monster2);
    game.physics.arcade.enable(this.monster3);
    game.physics.arcade.enable(this.monster4);
    
    game.add.tween(this.monster1).to({ x: "+320"}, 1500, Phaser.Easing.Linear.None, true, 0, 1000, true);
    game.add.tween(this.monster2).to({ x: "-320"}, 1100, Phaser.Easing.Linear.None, true, 0, 1000, true);
    game.add.tween(this.monster3).to({ x: "+192"}, 1000, Phaser.Easing.Linear.None, true, 0, 1000, true);
    game.add.tween(this.monster4).to({ x: "-320"}, 1500, Phaser.Easing.Linear.None, true, 0, 1000, true);
  },
 
  update: function() {
    game.physics.arcade.collide(this.car, this.layer);

    this.gridPos.x = game.math.snapToFloor(Math.floor(this.car.x),this.gridsize)/this.gridsize;
    this.gridPos.y = game.math.snapToFloor(Math.floor(this.car.y),this.gridsize)/this.gridsize;

    var i = this.layer.index;
    var x = this.gridPos.x;
    var y = this.gridPos.y;
    
    this.fourTiles[Phaser.LEFT] = this.map.getTileLeft(i, x, y);
    this.fourTiles[Phaser.RIGHT] = this.map.getTileRight(i, x, y);
    this.fourTiles[Phaser.UP] = this.map.getTileAbove(i, x, y);
    this.fourTiles[Phaser.DOWN] = this.map.getTileBelow(i, x, y);
    //碰撞觸發
    game.physics.arcade.overlap(this.car, this.levelup, this.levelupcar,null,this);
    game.physics.arcade.overlap(this.car, this.monster1, this.die1,null,this);
    game.physics.arcade.overlap(this.car, this.monster2, this.die2,null,this);
    game.physics.arcade.overlap(this.car, this.monster3, this.die3,null,this);
    game.physics.arcade.overlap(this.car, this.monster4, this.die4,null,this);
    game.physics.arcade.overlap(this.car, this.space, this.spacecar,null,this);
  },  
    
   onDown: function(pointer){ 
       if (pointer.y < 192)  {
           this.up123 = game.add.sprite(0, 0, 'up');
           game.add.tween(this.up123).to( { alpha: 0 }, 1000, Phaser.Easing.Linear.None, true);
           this.turn(Phaser.UP);
       } else if (pointer.y > 417) {
           this.down123 = game.add.sprite(0, 576, 'down');
           game.add.tween(this.down123).to( {alpha: 0 }, 1000, Phaser.Easing.Linear.None, true);
           this.turn(Phaser.DOWN);    
       } else if (pointer.x < 208 & pointer.y > 192 & pointer.y < 416) {
           this.left123 = game.add.sprite(0, 192, 'left');
           game.add.tween(this.left123).to( { alpha: 0 }, 1000, Phaser.Easing.Linear.None, true);
           this.turn(Phaser.LEFT);
       } else if (pointer.x > 208 & pointer.y > 192 & pointer.y < 416) {
           this.right123 = game.add.sprite(384, 192, 'right');
           game.add.tween(this.right123).to( { alpha: 0 }, 1000, Phaser.Easing.Linear.None, true);
           this.turn(Phaser.RIGHT);
       }
  },
  
  die1: function(car,monster1,monster2,monster3,monster4){       
    if(this.k>0){
      this.a++;
      this.monster1.kill();
      game.sound.play('eatmonster');
      if (this.a>3){
        this.space.loadTexture('finally');
      }
    } else {            
      if (this.life>1){
        this.life--;
        this.lifeText.text = '　　' + this.life;
        car.kill();
        mainbgm.pause();           
        game.sound.play('kill');    
        game.state.start('main'); 
      } else {
        this.life=3;
        mainbgm.pause();        
        game.state.start('lostgame');
      }                     
    }
  },
  die2: function(car,monster1,monster2,monster3,monster4){        
    if(this.k>0){
      this.a++;
      this.monster2.kill();
      game.sound.play('eatmonster');
      if (this.a>3){
        this.space.loadTexture('finally');
      }
    } else { 
      if (this.life>1){
        this.life--;
        this.lifeText.text = '　　' + this.life;
        car.kill();
        mainbgm.pause();           
        game.sound.play('kill');    
        game.state.start('main'); 
      } else {
        this.life=3;
        mainbgm.pause();
        game.state.start('lostgame');
      }         
    }       
  },
  die3: function(car,monster1,monster2,monster3,monster4){        
    if(this.k>0){
      this.a++;
      this.monster3.kill();
      game.sound.play('eatmonster');
      if (this.a>3){
        this.space.loadTexture('finally');
      }
    } else {            
      if (this.life>1){
        this.life--;
        this.lifeText.text = '　　' + this.life;
        car.kill();
        mainbgm.pause();           
        game.sound.play('kill');    
        game.state.start('main'); 
      } else {
        this.life=3;
        mainbgm.pause();
        game.state.start('lostgame');
      }             
    }    
  },
  die4: function(car,monster1,monster2,monster3,monster4){        
    if(this.k>0){
      this.a=1;
      this.monster4.kill();
      game.sound.play('eatmonster');
      if (this.a>3){
        this.space.loadTexture('finally');
      }
    } else {         
      if (this.life>1){
        this.life--;
        this.lifeText.text = '　　' + this.life;
        car.kill();
        mainbgm.pause();           
        game.sound.play('kill');    
        game.state.start('main'); 
      } else {
        this.life=3;
        mainbgm.pause();
        game.state.start('lostgame');
      }            
    }        
  },
  //碰撞後變主角2
  levelupcar: function(){ 
      game.sound.play('level');
      this.k=1;
      this.levelup.kill();      
      this.car.loadTexture('car2');    
  },
  //觸發獲勝條件
  spacecar: function(car,space){ 
      if (this.a>3){
         this.life=3;
         mainbgm.pause();
         game.state.start('wingame');   
      }         
  },
  
  move: function(to) {
    var speed = this.speed;
    if (to===Phaser.LEFT || to===Phaser.UP) {
      speed = -speed;
    }
    if (to===Phaser.LEFT || to===Phaser.RIGHT) {
      this.car.body.velocity.x = speed;
    } else {
      this.car.body.velocity.y = speed;
    }
    this.currentDir = to;    
  },

  turn: function(to) {
    if (this.currentDir===to || this.fourTiles[to]===null ||
        this.fourTiles[to].index!==this.safeTileIndex) {
      return;
    }
    if (this.currentDir===this.opposites[to]) {
      this.move(to);
      return;
    }
    this.turnPoint.x = this.gridPos.x*this.gridsize + this.gridsize/2;
    this.turnPoint.y = this.gridPos.y*this.gridsize + this.gridsize/2;

    var cx = Math.floor(this.car.x);
    var cy = Math.floor(this.car.y);
    if (!Phaser.Math.fuzzyEqual(cx, this.turnPoint.x, this.threshold) ||
        !Phaser.Math.fuzzyEqual(cy, this.turnPoint.y, this.threshold)) {
      return;
    }
    this.car.x = this.turnPoint.x;
    this.car.y = this.turnPoint.y;
    this.car.body.reset(this.turnPoint.x, this.turnPoint.y);
    this.move(to);
  },
};

var easymain = {  
  mainbgm: null,
  create: function() {
    //音樂
    mainbgm = game.add.audio('mainbgm');
    mainbgm.play();
    //預設值   
    this.safeTileIndex = 1;
    this.safeTileIndex2 = 2;
    this.safeTileIndex3 = 3;
    this.safeTileIndex4 = 4;
    this.gridsize = 32;
    this.speed = 300;
    this.threshold = 50;    
    this.gridPos = new Phaser.Point();
    this.turnPoint = new Phaser.Point();        
    this.fourTiles = [null, null, null, null, null];
    this.opposites = [Phaser.NONE, Phaser.RIGHT, Phaser.LEFT, Phaser.DOWN, Phaser.UP];
    this.currentDir = null;       
    //物理
    game.physics.startSystem(Phaser.Physics.ARCADE);
    //背景
    this.map = game.add.tilemap('map');
    this.map.addTilesetImage('tiles', 'mazeTiles');
    this.layer = this.map.createLayer('Tile Layer 2');
    this.map.setCollision(20, true, this.layer);
    //終點遮罩    
    this.space = game.add.sprite(32, 544, 'space');
    game.physics.arcade.enable(this.space);
    //主角
    this.car = game.add.sprite(48, 48, 'car');
    this.car.anchor.set(0.5);
    game.physics.arcade.enable(this.car);       
   //點擊
    this.cursors = game.input.onDown.add(this.onDown, this);
    //藥水
    this.levelup = game.add.sprite(192, 288, 'levelup');
    game.physics.arcade.enable(this.levelup);    
  },
 
  update: function() {
    game.physics.arcade.collide(this.car, this.layer);

    this.gridPos.x = game.math.snapToFloor(Math.floor(this.car.x),this.gridsize)/this.gridsize;
    this.gridPos.y = game.math.snapToFloor(Math.floor(this.car.y),this.gridsize)/this.gridsize;

    var i = this.layer.index;
    var x = this.gridPos.x;
    var y = this.gridPos.y;
    
    this.fourTiles[Phaser.LEFT] = this.map.getTileLeft(i, x, y);
    this.fourTiles[Phaser.RIGHT] = this.map.getTileRight(i, x, y);
    this.fourTiles[Phaser.UP] = this.map.getTileAbove(i, x, y);
    this.fourTiles[Phaser.DOWN] = this.map.getTileBelow(i, x, y);
    //碰撞觸發
    game.physics.arcade.overlap(this.car, this.levelup, this.levelupcar,null,this);   
    game.physics.arcade.overlap(this.car, this.space, this.spacecar,null,this);
  },  
    
   onDown: function(pointer){ 
       if (pointer.y < 192)  {
           this.up123 = game.add.sprite(0, 0, 'up');
           game.add.tween(this.up123).to( { alpha: 0 }, 1000, Phaser.Easing.Linear.None, true);
           this.turn(Phaser.UP);
       } else if (pointer.y > 417) {
           this.down123 = game.add.sprite(0, 576, 'down');
           game.add.tween(this.down123).to( {alpha: 0 }, 1000, Phaser.Easing.Linear.None, true);
           this.turn(Phaser.DOWN);    
       } else if (pointer.x < 208 & pointer.y > 192 & pointer.y < 416) {
           this.left123 = game.add.sprite(0, 192, 'left');
           game.add.tween(this.left123).to( { alpha: 0 }, 1000, Phaser.Easing.Linear.None, true);
           this.turn(Phaser.LEFT);
       } else if (pointer.x > 208 & pointer.y > 192 & pointer.y < 416) {
           this.right123 = game.add.sprite(384, 192, 'right');
           game.add.tween(this.right123).to( { alpha: 0 }, 1000, Phaser.Easing.Linear.None, true);
           this.turn(Phaser.RIGHT);
       }
  },
  
  //碰撞後變主角2
  levelupcar: function(){ 
      game.sound.play('level');      
      this.levelup.kill();      
      this.car.loadTexture('car2');    
      this.space.loadTexture('finally');
  },
  //觸發獲勝條件
  spacecar: function(car,space){ 
      mainbgm.pause();
      game.state.start('wingame');                  
  },
  
  move: function(to) {
    var speed = this.speed;
    if (to===Phaser.LEFT || to===Phaser.UP) {
      speed = -speed;
    }
    if (to===Phaser.LEFT || to===Phaser.RIGHT) {
      this.car.body.velocity.x = speed;
    } else {
      this.car.body.velocity.y = speed;
    }
    this.currentDir = to;    
  },

  turn: function(to) {
    if (this.currentDir===to || this.fourTiles[to]===null ||
        this.fourTiles[to].index!==this.safeTileIndex==this.safeTileIndex2==this.safeTileIndex3==this.safeTileIndex4) {
      return;
    }
    if (this.currentDir===this.opposites[to]) {
      this.move(to);
      return;
    }
    this.turnPoint.x = this.gridPos.x*this.gridsize + this.gridsize/2;
    this.turnPoint.y = this.gridPos.y*this.gridsize + this.gridsize/2;

    var cx = Math.floor(this.car.x);
    var cy = Math.floor(this.car.y);
    if (!Phaser.Math.fuzzyEqual(cx, this.turnPoint.x, this.threshold) ||
        !Phaser.Math.fuzzyEqual(cy, this.turnPoint.y, this.threshold)) {
      return;
    }
    this.car.x = this.turnPoint.x;
    this.car.y = this.turnPoint.y;
    this.car.body.reset(this.turnPoint.x, this.turnPoint.y);
    this.move(to);
  },
};

var titleScreen = {   
 titlebgm: null,  
 create: function() {
   //音樂
   titlebgm = game.add.audio('titlebgm');
   titlebgm.play();  
   //背景
   game.add.image(0, 0, 'startbg');
   //按鈕
   var goButton = game.add.button(game.width/2-125, game.height/1.53,"go", this.startGame, this);
   var setButton = game.add.button(game.width/2-125, game.height/1.28,"set", this.setGame, this);   
 },
  
 startGame: function() {
   titlebgm.pause();
   game.sound.play('yes');
   game.state.start('choose');   
 },
  
 setGame: function() {   
   titlebgm.pause();
   game.sound.play('yes');   
   game.state.start('setScreen');  
 },
};

var setScreen = { 
 create: function() {
   //背景
   game.add.image(0, 0, 'setbg');
   //圖解
   var set01 = game.add.image(game.width/2, 315, 'set01');
   set01.anchor.setTo(0.5, 0.5);  
   //按鈕    
   var gobackButton = game.add.button(game.width/2, 520,"goback", this.backGame, this) 
   gobackButton.anchor.setTo(0.5, 0.5); 
 },
  
 backGame: function() {
   game.sound.play('no');
   game.state.start('titleScreen');
 },
};

var wingame = {
 winbgm:null,
 create: function() {
   //音樂
   winbgm = game.add.audio('winbgm');
   winbgm.play(); 
   //背景
   game.add.image(0, 0, 'endbg');   
   //字體      
   var style = {
     font: '75px 微軟正黑體',
     fill: '#37281c',
     align: 'center'
   }
   //文字
   var text1 = game.add.text(game.width/2, 280, '恭喜你\n '  , style);
   var text2 = game.add.text(game.width/2, 400, '成功了！\n ' , style);
   text1.anchor.setTo(0.5, 0.5);
   text2.anchor.setTo(0.5, 0.5);
   //按鈕
   var goButton = game.add.button(game.width/2, game.height/2+480,"again", this.restartGame, this);   
   goButton.anchor.setTo(0.5, 0.5);
   game.add.tween(goButton).to({ y: "-300"}, 1000, Phaser.Easing.Linear.None, true);    
 },
  
 restartGame: function() {
   winbgm.pause();
   game.sound.play('no');
   game.state.start('titleScreen');
 },
};

var lostgame = {
 lostbgm:null,
 create: function() {
   //音樂
   lostbgm = game.add.audio('lostbgm');
   lostbgm.play(); 
   //背景
   game.add.image(0, 0, 'lostbg');        
   //按鈕
   var againButton = game.add.button(game.width/2, game.height/2+530,"again", this.restartGame, this);
   againButton.anchor.setTo(0.5, 0.5);
   game.add.tween(againButton).to({ y: "-300"}, 1000, Phaser.Easing.Linear.None, true);
 },
  
 restartGame: function() {
   lostbgm.pause();
   game.sound.play('no');
   game.state.start('titleScreen');
 },
};

var choose = {
 create: function() {   
   game.add.image(0, 0, 'choosebg');
   var choosebg1 = game.add.button(1000, 200, 'choosebg1', this.choose1, this);
   var choosebg2 = game.add.button(-500, 420, 'choosebg2', this.choose2, this);   
   choosebg1.anchor.setTo(0.5, 0.5);
   choosebg2.anchor.setTo(0.5, 0.5);
   game.add.tween(choosebg1).to({ x: game.width/2}, 500, Phaser.Easing.Linear.None, true);
   game.add.tween(choosebg2).to({ x: game.width/2}, 500, Phaser.Easing.Linear.None, true);
 },
  
 choose1: function() {
   game.sound.play('no');   
   game.state.start('easymain');
 }, 
  
 choose2: function() {
   game.sound.play('no');
   game.state.start('main');
 },  
};

var game = new Phaser.Game(416, 608, Phaser.AUTO, 'gameDiv');
game.state.add('Boot', Boot);
game.state.add('Preloader', Preloader);
game.state.add('titleScreen', titleScreen);
game.state.add('main', main);
game.state.add('easymain', easymain);
game.state.add('setScreen', setScreen);
game.state.add('lostgame', lostgame);
game.state.add('wingame', wingame);
game.state.add('choose', choose);
game.state.start('Boot');
