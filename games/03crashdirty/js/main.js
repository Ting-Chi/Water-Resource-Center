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
    game.load.image('background', 'assets/background.jpg');
    game.load.image('bubble', 'assets/bubble.png');
    game.load.image('monster', 'assets/monster.png');
    game.load.image('startbg','assets/startbg.png');    
    game.load.image('setbg','assets/setbg.png');
    game.load.image('endbg','assets/endbg.jpg');
    game.load.image('lostbg', 'assets/lostbg.jpg');
    game.load.image('set01','assets/set01.png');
    game.load.image('set02','assets/set02.png');
    game.load.image('choosebg','assets/choosebg.png');
    game.load.image('choosebg1','assets/choosebg1.png');
    game.load.image('choosebg2','assets/choosebg2.png');
	game.load.image('bg01','assets/bg01.jpg');
	game.load.image('bg02','assets/bg02.jpg');
	game.load.image('bg03','assets/bg03.jpg');
	game.load.image('bg04','assets/bg04.jpg');
	game.load.image('bg05','assets/bg05.jpg');
	game.load.image('bg06','assets/bg06.jpg');
	game.load.image('bg07','assets/bg07.jpg');
	game.load.image('bg08','assets/bg08.jpg');
	game.load.image('bg09','assets/bg09.jpg');
	game.load.image('bg00','assets/bg00.jpg');
    game.load.spritesheet('go', 'assets/go.png');
    game.load.spritesheet('set', 'assets/set.png');
    game.load.spritesheet('again', 'assets/again.png');
    game.load.spritesheet('goback', 'assets/goback.png');   
    game.load.audio('titlebgm', 'assets/titlebgm.mp3');
    game.load.audio('winbgm', 'assets/winbgm.mp3');
    game.load.audio('lostbgm', 'assets/lostbgm.mp3');
    game.load.audio('mainbgm', 'assets/mainbgm.mp3');
    game.load.audio('yes', 'assets/yes.mp3');
    game.load.audio('no', 'assets/no.mp3');     
  },
  
  update: function() {
    // Make sure all mp3 have been decoded before starting the game
    if (this.ready) {
      return;
    }
    if (game.cache.isSoundDecoded('titlebgm') &&
        game.cache.isSoundDecoded('mainbgm') &&
        game.cache.isSoundDecoded('winbgm')&&
        game.cache.isSoundDecoded('lostbgm')&&
        game.cache.isSoundDecoded('yes')&&
        game.cache.isSoundDecoded('no')) {
      this.ready = true;
      game.state.start('titleScreen');
    }    
  },
};

var main = {  
 score: 0,
 scoreText: null,
 timeLeft: 0,
 timeText: null,
 ten: 0,
 ben: 0, 
 mainbgm: null,
 create: function() { 
   //音樂
   mainbgm = game.add.audio('mainbgm');
   mainbgm.play();  
   //物理
   game.physics.startSystem(Phaser.Physics.ARCADE);
   //背景
   this.bg = game.add.image(0, 0, 'bg01');   
   //怪物
   monster = game.add.button(Math.random()*110+320, Math.random()*216+67, 'monster', this.touchgame, this);
   monster.anchor.setTo(0.5, 0.5);  
   //泡泡隨機產生範圍   
    var delay = 0;
    for (var i = 0; i < 40; i++)    {
        var sprite = game.add.sprite(-100 + (game.world.randomX), 800, 'bubble');
        sprite.scale.set(game.rnd.realInRange(0.1, 0.8));
        var speed = game.rnd.between(4000, 6000);
        game.add.tween(sprite).to({ y: -256 }, speed, Phaser.Easing.Sinusoidal.InOut, true, delay, 1000, false);
        delay += 200;
    }
   //預設值   
   this.ten = 0;
   this.ben = 0;   
   this.hitnow = 0;
   this.score = 30;
   this.timeLeft = 18;
   //字體
   var style = {
     font: '32px 微軟正黑體',
     fill: '#37281c',
     align: 'center'     
   }   
   var style2 = {
     font: '75px 微軟正黑體',
     fill: '#37281c',
     align: 'center'     
   }
   //文字
   this.scoreText = game.add.text(game.width/2, game.height-60, '還差：' + this.score + '隻', style);
   this.scoreText.anchor.setTo(0.5, 0.5);
   this.timeText = game.add.text(game.width/2, 60, this.timeLeft, style2);
   this.timeText.anchor.set(0.5, 0.5);
   //時間   
   game.time.events.loop(Phaser.Timer.SECOND, this.decreaseTime, this);
 },
   
 touchgame: function() {
   s = game.add.tween(monster.scale);   
   q = game.add.tween(monster);   
   if (this.score==1){
      mainbgm.pause();
      game.state.start('wingame');        
   } 
   else {
      this.score--;     
      this.scoreText.text = '還差：' + this.score + '隻';
      this.ten++;     
      if (this.ten>0){
          s.to({x: 1, y: 1}, 1, Phaser.Easing.Linear.None);
          s.start();          
          this.ten=0;         
           if (this.ben==3){     
              this.mmm31 = game.add.sprite(Math.random()*360+70, Math.random()*566+67, 'monster');
              this.mmm31.anchor.setTo(0.5, 0.5);
              m31 = game.add.tween(this.mmm31).to( { alpha: 0 }, 450, Phaser.Easing.Linear.None, true);
              q.to({ x: Math.random()*110+320 , y: Math.random()*216+67}, 5, Phaser.Easing.Linear.None, true);
              this.ben = Math.floor(Math.random()*4);
          }else if (this.ben==2){             
              this.mmm21 = game.add.sprite(Math.random()*360+70, Math.random()*566+67, 'monster');
              this.mmm21.anchor.setTo(0.5, 0.5);
              m21 = game.add.tween(this.mmm21).to( { alpha: 0 }, 450, Phaser.Easing.Linear.None, true);
              q.to({ x: Math.random()*110+70 , y: Math.random()*216+67}, 5, Phaser.Easing.Linear.None, true); 
              this.ben++;
          }else if (this.ben==1){      
              this.mmm11 = game.add.sprite(Math.random()*360+70, Math.random()*566+67, 'monster');
              this.mmm11.anchor.setTo(0.5, 0.5);
              m11 = game.add.tween(this.mmm11).to( { alpha: 0 }, 450, Phaser.Easing.Linear.None, true);
              q.to({ x: Math.random()*110+320 , y: Math.random()*216+417}, 5,  Phaser.Easing.Linear.None, true);
              this.ben++;
          }else { 
              this.mmm01 = game.add.sprite(Math.random()*360+70, Math.random()*566+67, 'monster');
              this.mmm01.anchor.setTo(0.5, 0.5);
              m01 = game.add.tween(this.mmm01).to( { alpha: 0 }, 450, Phaser.Easing.Linear.None, true);            
              q.to({ x: Math.random()*110+70 , y: Math.random()*216+417}, 5, Phaser.Easing.Linear.None, true);
              this.ben++;
          }          
      } 
      else {
          s.to({x: "+0.09", y:"+0.09"}, 80, Phaser.Easing.Linear.None);
          s.start();
      }     
   }   
 },
    
 decreaseTime: function() {
   this.timeLeft--;
   this.timeText.text = + this.timeLeft;
   if (this.timeLeft==0) {
      mainbgm.pause();
      game.state.start('gameOver');
   } 
   if (this.timeLeft==18){
	  this.bg.loadTexture('bg01');
   }
   if (this.timeLeft==17){
	  this.bg.loadTexture('bg02');
   }
   if (this.timeLeft==16){
	  this.bg.loadTexture('bg03');
   }
   if (this.timeLeft==15){
	  this.bg.loadTexture('bg04');
   }
   if (this.timeLeft==14){
	  this.bg.loadTexture('bg05');
   }
   if (this.timeLeft==13){
	  this.bg.loadTexture('bg06');
   }
   if (this.timeLeft==12){
	  this.bg.loadTexture('bg07');
   }
   if (this.timeLeft==11){
	  this.bg.loadTexture('bg08');
   }
   if (this.timeLeft==10){
	  this.bg.loadTexture('bg09');
   }
   if (this.timeLeft==9){
	  this.bg.loadTexture('bg00');
   }
   if (this.timeLeft==8){
	  this.bg.loadTexture('bg01');
   }
   if (this.timeLeft==7){
	  this.bg.loadTexture('bg02');
   }
   if (this.timeLeft==6){
	  this.bg.loadTexture('bg03');
   }
   if (this.timeLeft==5){
	  this.bg.loadTexture('bg04');
   }
   if (this.timeLeft==4){
	  this.bg.loadTexture('bg05');
   }
   if (this.timeLeft==3){
	  this.bg.loadTexture('bg06');
   }
   if (this.timeLeft==2){
	  this.bg.loadTexture('bg07');
   }
   if (this.timeLeft==1){
	  this.bg.loadTexture('bg08');
   }
 },
};

var easymain = {  
 score: 0,
 scoreText: null,
 timeLeft: 0,
 timeText: null,
 ten: 0,
 ben: 0, 
 mainbgm: null,
 create: function() { 
   //音樂
   mainbgm = game.add.audio('mainbgm');
   mainbgm.play();  
   //物理
   game.physics.startSystem(Phaser.Physics.ARCADE);
   //背景
   game.add.image(0, 0, 'background');
   //怪物
   monster = game.add.button(Math.random()*110+320, Math.random()*216+67, 'monster', this.touchgame, this);
   monster.anchor.setTo(0.5, 0.5);  
   //泡泡隨機產生範圍   
    var delay = 0;
    for (var i = 0; i < 40; i++)    {
        var sprite = game.add.sprite(-100 + (game.world.randomX), 800, 'bubble');
        sprite.scale.set(game.rnd.realInRange(0.1, 0.8));
        var speed = game.rnd.between(4000, 6000);
        game.add.tween(sprite).to({ y: -256 }, speed, Phaser.Easing.Sinusoidal.InOut, true, delay, 1000, false);
        delay += 200;
    }
   //預設值   
   this.ten = 0;
   this.ben = 0;   
   this.hitnow = 0;
   this.score = 10;
   this.timeLeft = 10;
   //字體
   var style = {
     font: '32px 微軟正黑體',
     fill: '#37281c',
     align: 'center'     
   }   
   var style2 = {
     font: '75px 微軟正黑體',
     fill: '#37281c',
     align: 'center'     
   }
   //文字
   this.scoreText = game.add.text(game.width/2, game.height-60, '還差：' + this.score + '隻', style);
   this.scoreText.anchor.setTo(0.5, 0.5);
   this.timeText = game.add.text(game.width/2, 60, this.timeLeft, style2);
   this.timeText.anchor.set(0.5, 0.5);
   //時間   
   game.time.events.loop(Phaser.Timer.SECOND, this.decreaseTime, this);
 },
  
 touchgame: function() {
   s = game.add.tween(monster.scale);   
   q = game.add.tween(monster);   
   if (this.score==1){
      mainbgm.pause();
      game.state.start('wingame');        
   } 
   else {
      this.score--;     
      this.scoreText.text = '還差：' + this.score + '隻';
      this.ten++;     
      if (this.ten>0){
          s.to({x: 1, y: 1}, 1, Phaser.Easing.Linear.None);
          s.start();          
          this.ten=0;         
           if (this.ben==3){     
              q.to({ x: Math.random()*110+320 , y: Math.random()*216+67}, 5, Phaser.Easing.Linear.None, true);
              this.ben = Math.floor(Math.random()*4);
          }else if (this.ben==2){  
              q.to({ x: Math.random()*110+70 , y: Math.random()*216+67}, 5, Phaser.Easing.Linear.None, true); 
              this.ben++;
          }else if (this.ben==1){     
              q.to({ x: Math.random()*110+320 , y: Math.random()*216+417}, 5,  Phaser.Easing.Linear.None, true);
              this.ben++;
          }else { 
              q.to({ x: Math.random()*110+70 , y: Math.random()*216+417}, 5, Phaser.Easing.Linear.None, true);
              this.ben++;
          }          
      } 
      else {
          s.to({x: "+0.09", y:"+0.09"}, 80, Phaser.Easing.Linear.None);
          s.start();
      }     
   }   
 },
    
 decreaseTime: function() {
   this.timeLeft--;
   this.timeText.text = + this.timeLeft;
   if (this.timeLeft==0) {
      mainbgm.pause();
      game.state.start('gameOver');
   }  
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
   //字體
   var style = {
   font: "100px Monospace",
   fill: "#FFFFFF",
   align: "center"
   }
   //按鈕
   var goButton = game.add.button(game.width/2, 500,"go", this.startGame, this);
   var setButton = game.add.button(game.width/2, 600,"set", this.setGame, this);  
   goButton.anchor.setTo(0.5, 0.5);
   setButton.anchor.setTo(0.5, 0.5);
   
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
   var set01 = game.add.image(game.width/2, 260, 'set01');
   var set02 = game.add.image(game.width/2, 415, 'set02');
   set01.anchor.setTo(0.5, 0.5);
   set02.anchor.setTo(0.5, 0.5);
   //字體
   var style = {
     font: '30px 微軟正黑體',
     fill: '#37281c',
     align: 'center',     
   }
   //按鈕
   var gobackButton = game.add.button(game.width/2+80, 590,"goback", this.backGame, this);
   gobackButton.anchor.setTo(0.5, 0.5);
 },
  
 backGame: function() {
   game.sound.play('no');
   game.state.start('titleScreen');
 },
};

var wingame = {
 bestscore: 0,  
 firstscore: 0, 
 winbgm: null,  
 create: function() {
   //音樂
   winbgm = game.add.audio('winbgm');
   winbgm.play();
   //背景
   game.add.image(0, 0, 'endbg');  
   //字體   
   var style = {
     font: '80px 微軟正黑體',
     fill: '#37281c',
     align: 'center'
   }  
   //文字
   var text = game.add.text(130, 240, '恭喜你\n '  , style);
   var text = game.add.text(105, 360, '成功了！\n ' , style);
   //按鈕
   var goButton = game.add.button(game.width/2, game.height/2+680,"again", this.restartGame, this);   
   goButton.anchor.setTo(0.5, 0.5); 
   game.add.tween(goButton).to({ y: game.height/2+220}, 1000, Phaser.Easing.Linear.None, true);     
 },
  
 restartGame: function() {
   winbgm.pause();
   game.sound.play('no');
   game.state.start('titleScreen');
 },
};

var gameOver = {
 lostbgm: null,  
 create: function() {     
   //音樂
   lostbgm = game.add.audio('lostbgm');
   lostbgm.play(); 
   //背景
   game.add.image(0, 0, 'lostbg');
   //按鈕
   var againButton = game.add.button(game.width/2, game.height/2+680,"again", this.restartGame, this);
   againButton.anchor.setTo(0.5, 0.5);   
   game.add.tween(againButton).to({ y: game.height/2+250}, 1000, Phaser.Easing.Linear.None, true);   
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
   var choosebg1 = game.add.button(1000, 230, 'choosebg1', this.choose1, this);
   var choosebg2 = game.add.button(-500, 470, 'choosebg2', this.choose2, this);   
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

var game = new Phaser.Game(500, 700, Phaser.AUTO, 'gameDiv');
game.state.add('Boot', Boot);
game.state.add('Preloader', Preloader);
game.state.add('titleScreen', titleScreen);
game.state.add('main', main);
game.state.add('easymain', easymain);
game.state.add('setScreen', setScreen);
game.state.add('wingame', wingame);
game.state.add('gameOver', gameOver);
game.state.add('choose', choose);
game.state.start('Boot');