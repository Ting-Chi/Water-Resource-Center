var Boot = {
 preload: function() {
   game.load.image('preload', 'assets/preload.png');
 },
 create: function() {
   //視窗調整程式
   game.scale.scaleMode = Phaser.ScaleManager.SHOW_ALL;
   game.scale.pageAlignVertically = true;   
   game.scale.pageAlignHorizontally = true;
   
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
    game.load.image('choosebg','assets/choosebg.png');
    game.load.image('choosebg1','assets/choosebg1.png');
    game.load.image('choosebg2','assets/choosebg2.png');
    game.load.image('knock', 'assets/knock.png');  
    game.load.image('knock2', 'assets/knock2.png');  
    game.load.image('set01', 'assets/set01.png');  
    game.load.spritesheet('go', 'assets/go.png');
    game.load.spritesheet('set', 'assets/set.png');
    game.load.spritesheet('goback', 'assets/goback.png');   
    game.load.spritesheet('again', 'assets/again.png');    
    game.load.audio('mainbgm', 'assets/mainbgm.mp3');
    game.load.audio('titlebgm', 'assets/titlebgm.mp3');
    game.load.audio('yes', 'assets/yes.mp3');
    game.load.audio('no', 'assets/no.mp3');
    game.load.audio('winbgm', 'assets/winbgm.mp3');
    game.load.audio('lostbgm', 'assets/lostbgm.mp3');
    game.load.audio('bubblemusic', 'assets/bubblemusic.mp3');    
  },
  
  update: function() {
    // Make sure all mp3 have been decoded before starting the game
    if (this.ready) {
      return;
    }
    if (game.cache.isSoundDecoded('mainbgm')&&
        game.cache.isSoundDecoded('titlebgm')&&
        game.cache.isSoundDecoded('yes')&&
        game.cache.isSoundDecoded('no')&&
        game.cache.isSoundDecoded('winbgm')&&
        game.cache.isSoundDecoded('lostbgm')&&
        game.cache.isSoundDecoded('bubblemusic')) {
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
 mathText: null,
 ten: 0,
 ben: 0,
 howmany: 0,
 mainbgm: null,
 b00: null,
 b0: null,
 b1: null,
 b2: null,
 b3: null,
 b4: null,
 b5: null,
 a: 0,
 create: function() {  
   //音樂
   mainbgm = game.add.audio('mainbgm');
   b5 = game.add.audio('bubblemusic');   
   b4 = game.add.audio('bubblemusic');   
   b3 = game.add.audio('bubblemusic');   
   b2 = game.add.audio('bubblemusic');   
   b1 = game.add.audio('bubblemusic');   
   b0 = game.add.audio('bubblemusic');   
   b00 = game.add.audio('bubblemusic'); 
   mainbgm.play();  
   //物理
   game.physics.startSystem(Phaser.Physics.ARCADE);
   //背景   
   game.add.image(0, 0, 'background');
   //怪物
   monster = game.add.sprite(260, 400, 'monster');
   monster.anchor.setTo(0.5, 0.5);
   //點擊!!!
   knock = game.add.sprite(game.width/2, game.height-120, 'knock');   
   knock.anchor.setTo(0.5, 0.5);   
   game.add.tween(knock).to({ alpha: 0}, 500,Phaser.Easing.Linear.None, true, 0,100,true);       
   knock2 = game.add.sprite(game.width/2, game.height-120, 'knock2');   
   knock2.anchor.setTo(0.5, 0.5);   
   knock2.alpha = 0;   
   game.add.tween(knock2).to({ alpha: 1}, 500,Phaser.Easing.Linear.None, true, 0,100,true); 
   //產生泡泡程式
   var delay = 0;
    for (var i = 0; i < 40; i++)    {
        var sprite = game.add.sprite(-100 + (game.world.randomX), 800, 'bubble');
        sprite.scale.set(game.rnd.realInRange(0.1, 0.8));
        var speed = game.rnd.between(4000, 6000);
        game.add.tween(sprite).to({ y: -256 }, speed, Phaser.Easing.Sinusoidal.InOut, true, delay, 1000, false);
        delay += 200;
    }   
   //預設值
   this.a=0;
   this.ten = 0;
   this.ben = 0;
   this.howmany = 3;
   this.hitnow = 0;
   this.score = 80;
   this.timeLeft = 7;
   //字體
   var style = {
     font: '74px 微軟正黑體',
     fill: '#37281c',
     align: 'center'     
   }
   var style2 = {
     font: '36px 微軟正黑體',
     fill: '#37281c',
     align: 'center'     
   }
   //文字
   this.scoreText = game.add.text(game.width, game.height, '分數：' + this.score, style);
   this.timeText = game.add.text(game.width/2, 50, this.timeLeft, style);
   this.timeText.anchor.set(0.5, 0.5);
   this.mathText = game.add.text(game.width/2, game.height-50, '還差：8隻', style2);
   this.mathText.anchor.set(0.5, 0.5);
   //時間
   game.time.events.loop(Phaser.Timer.SECOND, this.decreaseTime, this);
   //觸碰螢幕
   game.input.onDown.add(this.touchgame, this);   
 },
  
 touchgame: function() {   
   s = game.add.tween(monster.scale);   
   q = game.add.tween(monster);
   if (this.score==1){
      mainbgm.pause();
      b00.pause();
      b0.pause();
      b1.pause();
      b2.pause();
      b3.pause();
      b4.pause();
      b5.pause();
      game.state.start('wingame');        
   } 
   else {
      this.score--;     
      this.scoreText.text = '分數：' + this.score;       
      this.ten++;     
      if (this.ten>9){
          s.to({x: 1, y: 1}, 1, Phaser.Easing.Linear.None);
          s.start();
          this.howmany++;
          this.ten=0;         
          if (this.ben>5){
			  this.mathText.text ='還差：1隻';
              this.mmm71 = game.add.sprite(150, 610, 'monster');
              this.mmm72 = game.add.sprite(150, 610, 'monster');
              this.mmm73 = game.add.sprite(150, 610, 'monster');
              this.mmm71.anchor.setTo(0.5, 0.5);
              this.mmm72.anchor.setTo(0.5, 0.5);
              this.mmm73.anchor.setTo(0.5, 0.5);
              m11 = game.add.tween(this.mmm71).to( { x: 300, alpha: 0 }, 900, Phaser.Easing.Linear.None, true);
              m12 = game.add.tween(this.mmm72).to( { x: 0, alpha: 0 }, 900, Phaser.Easing.Linear.None, true);
              m13 = game.add.tween(this.mmm73).to( { alpha: 0 }, 150, Phaser.Easing.Linear.None, true);
              q.to({ x: 260 , y: 400}, 5, Phaser.Easing.Linear.None, true);                          
              b5.play();  
              this.ben++;
          }else if (this.ben>4){
			  this.mathText.text ='還差：2隻';
              this.mmm61 = game.add.sprite(410, 370, 'monster');
              this.mmm62 = game.add.sprite(410, 370, 'monster');
              this.mmm63 = game.add.sprite(410, 370, 'monster');
              this.mmm61.anchor.setTo(0.5, 0.5);
              this.mmm62.anchor.setTo(0.5, 0.5);
              this.mmm63.anchor.setTo(0.5, 0.5);
              m11 = game.add.tween(this.mmm61).to( { x: 560, alpha: 0 }, 900, Phaser.Easing.Linear.None, true);
              m12 = game.add.tween(this.mmm62).to( { x: 260, alpha: 0 }, 900, Phaser.Easing.Linear.None, true);
              m13 = game.add.tween(this.mmm63).to( { alpha: 0 }, 150, Phaser.Easing.Linear.None, true);
              q.to({ x: 150 , y: 610}, 5, Phaser.Easing.Linear.None, true);                         
              b4.play(); 
              this.ben++;
          }else if (this.ben>3){
			  this.mathText.text ='還差：3隻';
              this.mmm51 = game.add.sprite(350, 170, 'monster');
              this.mmm52 = game.add.sprite(350, 170, 'monster');
              this.mmm53 = game.add.sprite(350, 170, 'monster');
              this.mmm51.anchor.setTo(0.5, 0.5);
              this.mmm52.anchor.setTo(0.5, 0.5);
              this.mmm53.anchor.setTo(0.5, 0.5);
              m11 = game.add.tween(this.mmm51).to( { x: 500, alpha: 0 }, 900, Phaser.Easing.Linear.None, true);
              m12 = game.add.tween(this.mmm52).to( { x: 200, alpha: 0 }, 900, Phaser.Easing.Linear.None, true);
              m13 = game.add.tween(this.mmm53).to( { alpha: 0 }, 150, Phaser.Easing.Linear.None, true);
              q.to({ x: 410 , y: 370}, 5, Phaser.Easing.Linear.None, true);  
              b3.play(); 
              this.ben++;
          }else if (this.ben>2){
			  this.mathText.text ='還差：4隻';
              this.mmm41 = game.add.sprite(100, 560, 'monster');
              this.mmm42 = game.add.sprite(100, 560, 'monster');
              this.mmm43 = game.add.sprite(100, 560, 'monster');
              this.mmm41.anchor.setTo(0.5, 0.5);
              this.mmm42.anchor.setTo(0.5, 0.5);
              this.mmm43.anchor.setTo(0.5, 0.5);
              m11 = game.add.tween(this.mmm41).to( { x: 250, alpha: 0 }, 900, Phaser.Easing.Linear.None, true);
              m12 = game.add.tween(this.mmm42).to( { x: -50, alpha: 0 }, 900, Phaser.Easing.Linear.None, true);
              m13 = game.add.tween(this.mmm43).to( { alpha: 0 }, 150, Phaser.Easing.Linear.None, true);
              q.to({ x: 350 , y: 170}, 5, Phaser.Easing.Linear.None, true);   
              b2.play(); 
              this.ben++;
          }else if (this.ben>1){
			  this.mathText.text ='還差：5隻';
              this.mmm31 = game.add.sprite(350, 610, 'monster');
              this.mmm32 = game.add.sprite(350, 610, 'monster');
              this.mmm33 = game.add.sprite(350, 610, 'monster');
              this.mmm31.anchor.setTo(0.5, 0.5);
              this.mmm32.anchor.setTo(0.5, 0.5);
              this.mmm33.anchor.setTo(0.5, 0.5);
              m11 = game.add.tween(this.mmm31).to( { x: 500, alpha: 0 }, 900, Phaser.Easing.Linear.None, true);
              m12 = game.add.tween(this.mmm32).to( { x: 200, alpha: 0 }, 900, Phaser.Easing.Linear.None, true);
              m13 = game.add.tween(this.mmm33).to( { alpha: 0 }, 150, Phaser.Easing.Linear.None, true);
              q.to({ x: 100 , y: 560}, 5, Phaser.Easing.Linear.None, true); 
              b1.play();  
              this.ben++;
          }else if (this.ben>0){
			  this.mathText.text ='還差：6隻';
              this.mmm21 = game.add.sprite(170, 190, 'monster');
              this.mmm22 = game.add.sprite(170, 190, 'monster');
              this.mmm23 = game.add.sprite(170, 190, 'monster');
              this.mmm21.anchor.setTo(0.5, 0.5);
              this.mmm22.anchor.setTo(0.5, 0.5);
              this.mmm23.anchor.setTo(0.5, 0.5);
              m11 = game.add.tween(this.mmm21).to( { x: 320, alpha: 0 }, 900, Phaser.Easing.Linear.None, true);
              m12 = game.add.tween(this.mmm22).to( { x: 20, alpha: 0 }, 900, Phaser.Easing.Linear.None, true);
              m13 = game.add.tween(this.mmm23).to( { alpha: 0 }, 150, Phaser.Easing.Linear.None, true);
              q.to({ x: 350 , y: 610}, 5, Phaser.Easing.Linear.None, true);
              b0.play(); 
              this.ben++;
          }else {
			　this.mathText.text ='還差：7隻';
              this.mmm11 = game.add.sprite(260, 400, 'monster');
              this.mmm12 = game.add.sprite(260, 400, 'monster');
              this.mmm13 = game.add.sprite(260, 400, 'monster');
              this.mmm11.anchor.setTo(0.5, 0.5);
              this.mmm12.anchor.setTo(0.5, 0.5);
              this.mmm13.anchor.setTo(0.5, 0.5);
              m11 = game.add.tween(this.mmm11).to( { x: 410, alpha: 0 }, 900, Phaser.Easing.Linear.None, true);
              m12 = game.add.tween(this.mmm12).to( { x: 110, alpha: 0 }, 900, Phaser.Easing.Linear.None, true);
              m13 = game.add.tween(this.mmm13).to( { alpha: 0 }, 150, Phaser.Easing.Linear.None, true);
              q.to({ x: 170 , y: 190}, 5, Phaser.Easing.Linear.None, true);
              b00.play();   
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
      b00.pause();
      b0.pause();
      b1.pause();
      b2.pause();
      b3.pause();
      b4.pause();
      b5.pause();
      game.state.start('gameOver');
   }  
 },
};

var easymain = {  
 score: 0,
 scoreText: null,
 timeLeft: 0,
 timeText: null, 
 mathText: null,
 ten: 0,
 ben: 0,
 howmany: 0,
 mainbgm: null,
 b00: null,
 b0: null,
 b1: null,
 create: function() {  
   //音樂
   mainbgm = game.add.audio('mainbgm');   
   b1 = game.add.audio('bubblemusic');   
   b0 = game.add.audio('bubblemusic');   
   b00 = game.add.audio('bubblemusic'); 
   mainbgm.play();  
   //物理
   game.physics.startSystem(Phaser.Physics.ARCADE);
   //背景   
   game.add.image(0, 0, 'background');
   //怪物
   monster = game.add.sprite(110, 220, 'monster');
   monster.anchor.setTo(0.5, 0.5);
   //點擊!!!
   knock = game.add.sprite(game.width/2, game.height-120, 'knock');   
   knock.anchor.setTo(0.5, 0.5);   
   game.add.tween(knock).to({ alpha: 0}, 500,Phaser.Easing.Linear.None, true, 0,100,true);       
   knock2 = game.add.sprite(game.width/2, game.height-120, 'knock2');   
   knock2.anchor.setTo(0.5, 0.5);   
   knock2.alpha = 0;   
   game.add.tween(knock2).to({ alpha: 1}, 500,Phaser.Easing.Linear.None, true, 0,100,true);
   //產生怪物程式
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
   this.howmany = 3;
   this.hitnow = 0;
   this.score = 30;
   this.timeLeft = 7;
   //字體
   var style = {
     font: '74px 微軟正黑體',
     fill: '#37281c',
     align: 'center'     
   }
   var style2 = {
     font: '36px 微軟正黑體',
     fill: '#37281c',
     align: 'center'     
   }
   //文字
   this.scoreText = game.add.text(game.width, game.height, '分數：' + this.score, style);
   this.timeText = game.add.text(game.width/2, 50, this.timeLeft, style);
   this.timeText.anchor.set(0.5, 0.5);
   this.mathText = game.add.text(game.width/2, game.height-50, '還差：3隻', style2);
   this.mathText.anchor.set(0.5, 0.5);
   //時間
   game.time.events.loop(Phaser.Timer.SECOND, this.decreaseTime, this);
   //觸碰螢幕
   game.input.onDown.add(this.touchgame, this);   
 },
  
 touchgame: function() {
   s = game.add.tween(monster.scale);   
   q = game.add.tween(monster);
   if (this.score==1){
      mainbgm.pause();
      b00.pause();
      b0.pause();
      b1.pause();
      game.state.start('wingame');        
   } 
   else {
      this.score--;     
      this.scoreText.text = '分數：' + this.score;       
      this.ten++;     
      if (this.ten>9){		  
          s.to({x: 1, y: 1}, 1, Phaser.Easing.Linear.None);
          s.start();
          this.howmany++;
          this.ten=0;         
          if (this.ben>1){
			  this.mathText.text ='還差：0隻';
              this.mmm31 = game.add.sprite(400, 333, 'monster');
              this.mmm32 = game.add.sprite(400, 333, 'monster');
              this.mmm33 = game.add.sprite(400, 333, 'monster');
              this.mmm31.anchor.setTo(0.5, 0.5);
              this.mmm32.anchor.setTo(0.5, 0.5);
              this.mmm33.anchor.setTo(0.5, 0.5);
              m11 = game.add.tween(this.mmm31).to( { x: 600, alpha: 0 }, 900, Phaser.Easing.Linear.None, true);
              m12 = game.add.tween(this.mmm32).to( { x: 200, alpha: 0 }, 900, Phaser.Easing.Linear.None, true);
              m13 = game.add.tween(this.mmm33).to( { alpha: 0 }, 150, Phaser.Easing.Linear.None, true);
              q.to({ x: 100 , y: 560}, 5, Phaser.Easing.Linear.None, true); 
              b1.play();  
              this.ben++;
          }else if (this.ben>0){
			  this.mathText.text ='還差：1隻';
              this.mmm21 = game.add.sprite(300, 550, 'monster');
              this.mmm22 = game.add.sprite(300, 550, 'monster');
              this.mmm23 = game.add.sprite(300, 550, 'monster');
              this.mmm21.anchor.setTo(0.5, 0.5);
              this.mmm22.anchor.setTo(0.5, 0.5);
              this.mmm23.anchor.setTo(0.5, 0.5);
              m11 = game.add.tween(this.mmm21).to( { x: 500, alpha: 0 }, 900, Phaser.Easing.Linear.None, true);
              m12 = game.add.tween(this.mmm22).to( { x: 100, alpha: 0 }, 900, Phaser.Easing.Linear.None, true);
              m13 = game.add.tween(this.mmm23).to( { alpha: 0 }, 150, Phaser.Easing.Linear.None, true);
              q.to({ x: 400 , y: 330}, 5, Phaser.Easing.Linear.None, true);
              b0.play(); 
              this.ben++;
          }else {
			  this.mathText.text ='還差：2隻';
              this.mmm11 = game.add.sprite(110, 220, 'monster');
              this.mmm12 = game.add.sprite(110, 220, 'monster');
              this.mmm13 = game.add.sprite(110, 220, 'monster');
              this.mmm11.anchor.setTo(0.5, 0.5);
              this.mmm12.anchor.setTo(0.5, 0.5);
              this.mmm13.anchor.setTo(0.5, 0.5);
              m11 = game.add.tween(this.mmm11).to( { x: 310, alpha: 0 }, 900, Phaser.Easing.Linear.None, true);
              m12 = game.add.tween(this.mmm12).to( { x: -90, alpha: 0 }, 900, Phaser.Easing.Linear.None, true);
              m13 = game.add.tween(this.mmm13).to( { alpha: 0 }, 150, Phaser.Easing.Linear.None, true);
              q.to({ x: 300 , y: 550}, 5, Phaser.Easing.Linear.None, true);
              b00.play();   
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
      b00.pause();
      b0.pause();
      b1.pause();
      b2.pause();
      b3.pause();
      b4.pause();
      b5.pause();
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
   var set01 = game.add.image(game.width/2, 400,'set01');
   set01.anchor.setTo(0.5, 0.5);
   //按鈕   
   var gobackButton = game.add.button(game.width/2+100, 610,"goback", this.backgame, this);
   gobackButton.anchor.setTo(0.5, 0.5);
 },
 backgame: function() {
   game.sound.play('no');
   game.state.start('titleScreen');
 },
};

var wingame = { 
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
   var againButton = game.add.button(game.width/2, game.height/2+650,"again", this.restartGame, this);
   againButton.anchor.setTo(0.5, 0.5); 
   game.add.tween(againButton).to({ y: game.height/2+220}, 1000, Phaser.Easing.Linear.None, true);      
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
   var againButton = game.add.button(game.width/2, game.height/2+700,"again", this.restartGame, this);
   againButton.anchor.setTo(0.5, 0.5);  
   game.add.tween(againButton).to({ y: game.height/2+270}, 1000, Phaser.Easing.Linear.None, true);   
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