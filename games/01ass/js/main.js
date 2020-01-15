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
    game.load.image('water', 'assets/water.png');
    game.load.image('waterbutton', 'assets/waterbutton.png');
    game.load.image('garbage', 'assets/garbage.png');
    game.load.image('garbagebutton', 'assets/garbagebutton.png');
	game.load.image('background', 'assets/background.jpg');
    game.load.image('startbg','assets/startbg.png');
    game.load.image('setbg','assets/setbg.png');
    game.load.image('endbg','assets/endbg.jpg');    
    game.load.image('set01','assets/set01.png');  
    game.load.image('set02','assets/set02.png');
    game.load.image('set03','assets/set03.png'); 
	game.load.image('allbg', 'assets/allbg.png');		
	game.load.spritesheet('all', 'assets/all.png');	
	game.load.spritesheet('all2', 'assets/all2.png');	
    game.load.spritesheet('catch', 'assets/catch.png');
    game.load.spritesheet('go', 'assets/go.png');
    game.load.spritesheet('set', 'assets/set.png');
    game.load.spritesheet('again', 'assets/again.png');
    game.load.spritesheet('goback', 'assets/goback.png'); 
	game.load.spritesheet('none', 'assets/none.png');	
    game.load.audio('buttonright', 'assets/buttonright.mp3');
    game.load.audio('buttonright2', 'assets/buttonright2.mp3');
    game.load.audio('buttonwrong', 'assets/buttonwrong.mp3');
    game.load.audio('mainbgm', 'assets/mainbgm.mp3');     
    game.load.audio('titlebgm', 'assets/titlebgm.mp3');
    game.load.audio('yes', 'assets/yes.mp3');   
    game.load.audio('no', 'assets/no.mp3');    
    game.load.audio('winbgm', 'assets/winbgm.mp3');   
  },
  
  update: function() {
    // Make sure all mp3s have been decoded before starting the game
    if (this.ready) {
      return;
    } else if (game.cache.isSoundDecoded('buttonright') &&
        game.cache.isSoundDecoded('buttonright2') &&
        game.cache.isSoundDecoded('buttonwrong')&&
        game.cache.isSoundDecoded('mainbgm')&&
        game.cache.isSoundDecoded('titlebgm')&&
        game.cache.isSoundDecoded('yes')&&
        game.cache.isSoundDecoded('no')&&
        game.cache.isSoundDecoded('winbgm')) {
      this.ready = true;
      game.state.start('titleScreen');
    }    
  },
};

var main = {  
 worD:[],     //判斷水or垃圾
 dArray:[],    //製作水&垃圾
 gameType:'01ass', //ass遊戲編號(典)
 score: 0,
 scoreText: null,
 timeLeft: 0,
 timeText: null,
 hitnow: 0,
 mainbgm: null,  
 create: function() {  
   //音樂
   mainbgm = game.add.audio('mainbgm');
   mainbgm.play();  
   //物理
   game.physics.startSystem(Phaser.Physics.ARCADE);
   //跳出即暫停
   game.stage.disableVisibilityChange = true;
   //背景
   game.add.image(0, 0, 'background');
   //產生垃圾&水
   var a = 0; 
   for (var i=0; i<200; i++){     
     if (Math.random()*100 > 75) {
        this.dArray[a] = game.add.group();
        this.dArray[a] = game.add.sprite(283-i*70, 343, 'garbage');
        this.worD[a] = 0;
     }
     else {  
        this.dArray[a] = game.add.group();
        this.dArray[a] = game.add.sprite(283-i*70, 343, 'water');
        this.worD[a] = 1;
     } 
     a++;
   }  
   //爪子
   this.catch = game.add.sprite(318.5, 163, 'catch'); 
   //按鈕
   var garbagebutton = game.add.button(30,470,'garbagebutton', this.hitbutton, this);
   var waterbutton = game.add.button(290,480,'waterbutton', this.hitbutton2, this);          
   //預設值
   this.hitnow = 0;
   this.score = 0;
   this.timeLeft = 15;
   //字體
   var style = {
     font: '50px 微軟正黑體',
     fill: '#37281c',
     align: 'center'     
   }
   //顯示文字
   this.scoreText = game.add.text(5, 5, '分數：' + this.score, style);
   this.timeText = game.add.text(5, 65, '時間：' + this.timeLeft, style);
   //跑時間
   game.time.events.loop(Phaser.Timer.SECOND, this.decreaseTime, this);
   
 },  
  
 //垃圾按鈕
 hitbutton: function() {   
   console.log(this.hitnow);
   console.log(this.worD[this.hitnow]);
   game.add.tween(this.catch).to({ x: 280 , y: 440}, 50, Phaser.Easing.Linear.None, true, 0, 0, true);
   if ( this.worD[this.hitnow]==0) {
	  for (var s=0; s<200; s++){  
		this.dArry = game.add.tween(this.dArray[s]).to({ x: "+70" }, 70, Phaser.Easing.Linear.None, true);
      }
	  game.add.tween(this.catch).to({x:318.5, y:163}, 40, Phaser.Easing.Linear.None, true);     	  
      game.sound.play('buttonright2');
      for (var g=0; g<2; g++){
      this.score++;}
      this.scoreText.text = '分數：' + this.score;   
	  this.dArray[this.hitnow].destroy();
	  this.hitnow ++ ;  
   } else {
     game.sound.play('buttonwrong');
     //遮罩按鈕
     this.none = game.add.button(0, 0, 'none'); 
     this.none.alpha = 0;
     game.time.events.add(Phaser.Timer.SECOND, this.dienone, this);
   }      
 },
 //水按鈕 
 hitbutton2: function() {    
   if ( this.worD[this.hitnow]==1) {
	  for (var s=0; s<200; s++){  
		this.dArry = game.add.tween(this.dArray[s]).to({ x: "+70" }, 70, Phaser.Easing.Linear.None, true);
      }
      game.sound.play('buttonright');
      for (var g=0; g<1; g++){
      this.score++;}
      this.scoreText.text = '分數：' + this.score;   
	  this.dArray[this.hitnow].destroy();
	  this.hitnow ++ ;
   }  else {
     game.sound.play('buttonwrong');
	 //遮罩按鈕
     this.none = game.add.button(0, 0, 'none'); 
     this.none.alpha = 0;
     game.time.events.add(Phaser.Timer.SECOND, this.dienone, this);
   }   
 },  
 //時間到
 decreaseTime: function() {
   this.timeLeft--;
   this.timeText.text = '時間：' + this.timeLeft;
   if (this.timeLeft==0) {
      mainbgm.pause();
      game.state.start('gameOver');  
   }   
 },  
 //破壞按鈕遮罩
 dienone: function() {
    this.none.destroy();
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
   var goButton = game.add.button(game.width/2, 400,"go", this.startgame, this);
   var setButton = game.add.button(game.width/2, 600,"set", this.setgame, this); 
   var allButton = game.add.button(game.width/2, 500,"all", this.allgame, this);
   allButton.anchor.setTo(0.5, 0.5);
   goButton.anchor.setTo(0.5, 0.5);
   setButton.anchor.setTo(0.5, 0.5);
 },
 startgame: function() {
   titlebgm.pause();
   game.sound.play('yes');   
   game.state.start('main');
 },
  setgame: function() {   
   titlebgm.pause();
   game.sound.play('yes');
   game.state.start('setScreen');  
 },
  allgame: function() {   
   titlebgm.pause();   
   window.location="../ranking.php?gameType=01ass";  
 },

};

var setScreen = { 
 create: function() {
   //背景
   var setbg = game.add.image(0, 0, 'setbg'); 
   //圖解
   var set01 = game.add.image(game.width/2, 245, 'set01');
   set01.anchor.setTo(0.5, 0.5);
   var set02 = game.add.image(game.width/2, 375, 'set02');
   set02.anchor.setTo(0.5, 0.5);
   var set03 = game.add.image(game.width/2, 505, 'set03');
   set03.anchor.setTo(0.5, 0.5);
   //按鈕
   var gobackButton = game.add.button(game.width/2+100, 610,"goback", this.backgame, this);
   gobackButton.anchor.setTo(0.5, 0.5);     
   //字體   
 },
  
 backgame: function() {
   game.sound.play('no');
   game.state.start('titleScreen');
 },
};

var gameOver = {
 bestscore: 0,  
 firstscore: 0,   
 create: function() {
   //音樂
   winbgm = game.add.audio('winbgm');
   winbgm.play();
   //背景
   var endbg = game.add.image(0, 0, 'endbg');   
   //分數抓取
   this.firstscore = 0;   
   this.firstscore = main.score;
   if (this.firstscore > this.bestscore){
     this.bestscore = this.firstscore;    
   }
   //字體       
   var style = {
     font: '50px 微軟正黑體',
     fill: '#37281c',
     align: 'center'
   }    
   //文字
   var text1 = game.add.text(game.width/2, 230, '遊戲結束'  , style);
   var text2 = game.add.text(game.width/2, 300, '您的分數是' , style);
   var text3 = game.add.text(game.width/2, 385, main.score , style);   
   //var text4 = game.add.text(game.width/2, 410, '最高紀錄' , style);
   //var text5 = game.add.text(game.width/2, 485, this.bestscore , style);
   
   //將成績傳到html中   
   document.getElementById('score').value=main.score;
   document.getElementById('gameType').value=main.gameType;
   
   text1.anchor.setTo(0.5, 0.5);
   text2.anchor.setTo(0.5, 0.5);
   text3.anchor.setTo(0.5, 0.5);
   //text4.anchor.setTo(0.5, 0.5);
   //text5.anchor.setTo(0.5, 0.5);
   //按鈕
   var againButton = game.add.button(game.width/2+300, 478,"again", this.restartGame, this);
   againButton.anchor.setTo(0.5, 0.5);   
   game.add.tween(againButton).to({ x: "-300"}, 1300, Phaser.Easing.Linear.None, true);   
   var updateButton = game.add.button(game.width/2-300, 575,"all2", this.updategame, this);
   updateButton.anchor.setTo(0.5, 0.5); 
   game.add.tween(updateButton).to({ x: "+300"}, 1300, Phaser.Easing.Linear.None, true);      
 },
  
 restartGame: function() {
   winbgm.pause();
   game.sound.play('no');
   main.dArray.length = 0;
   main.worD.length = 0;   
   game.state.start('titleScreen');
 },
 updategame: function() {   
   titlebgm.pause();
   game.sound.play('yes');
   scoreForm.submit(); //送出 
   //window.location="../ranking.php";
 },
};

var game = new Phaser.Game(500, 700, Phaser.AUTO, 'gameDiv');
game.state.add('Boot', Boot);
game.state.add('Preloader', Preloader);
game.state.add('titleScreen', titleScreen);
game.state.add('main', main);
game.state.add('setScreen', setScreen);
game.state.add('gameOver', gameOver);
game.state.start('Boot');