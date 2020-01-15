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
   game.load.image('background','assets/background.jpg');
   game.load.image('game03','assets/game03.png');
   game.load.image('startbg','assets/startbg.png');    
   game.load.image('setbg','assets/setbg.png'); 
   game.load.image('endbg','assets/endbg.jpg');
   game.load.image('again','assets/again.png');
   game.load.image('choosebg','assets/choosebg.png');
   game.load.image('choosebg1','assets/choosebg1.png');
   game.load.image('choosebg2','assets/choosebg2.png');
   game.load.image('set01','assets/set01.png');
   game.load.image('allbg', 'assets/allbg.png');
   game.load.spritesheet('all', 'assets/all.png');
   game.load.spritesheet('all2', 'assets/all2.png');
   game.load.spritesheet('game01','assets/game01.png',127 ,80);
   game.load.spritesheet('game02','assets/game02.png',127 ,80);
   game.load.spritesheet('game04','assets/game04.png');
   game.load.spritesheet('game05','assets/game05.png');
   game.load.spritesheet('game06','assets/game06.png');
   game.load.spritesheet('game06a','assets/game06a.png');
   game.load.spritesheet('game07','assets/game07.png');
   game.load.spritesheet('game07a','assets/game07a.png');
   game.load.spritesheet('game08','assets/game08.png');
   game.load.spritesheet('game09','assets/game09.png');
   game.load.spritesheet('game10','assets/game10.png');
   game.load.spritesheet('game11','assets/game11.png');
   game.load.spritesheet('game12','assets/game12.png',218 ,137);  
   game.load.spritesheet('set', 'assets/set.png');
   game.load.spritesheet('go', 'assets/go.png');
   game.load.spritesheet('goback', 'assets/goback.png');  
   game.load.audio('mainbgm', 'assets/mainbgm.mp3'); 
   game.load.audio('titlebgm', 'assets/titlebgm.mp3'); 
   game.load.audio('winbgm', 'assets/winbgm.mp3');
   game.load.audio('yes', 'assets/yes.mp3');
   game.load.audio('yes2', 'assets/yes2.mp3');    
   game.load.audio('no', 'assets/no.mp3');   
   game.load.audio('no2', 'assets/no2.mp3');       
 },
 update: function() {   
   if (this.ready) {
    return;
   }
   if (game.cache.isSoundDecoded('mainbgm') &&
   game.cache.isSoundDecoded('titlebgm')&&
   game.cache.isSoundDecoded('winbgm') &&
   game.cache.isSoundDecoded('yes') &&
   game.cache.isSoundDecoded('no')&&
   game.cache.isSoundDecoded('yes2') &&
   game.cache.isSoundDecoded('no2')) {
     this.ready = true;
     game.state.start('titleScreen');
   }
 }, 
};

var main = {  
  score: 0,  
  scoreText: null,  
  gameType:'05muni', //05muni遊戲編號(典)  
  timeLeft: 0,
  shortArray:[],    //短的群組
  mainbgm: null,  
 create: function() {
   //音樂
   mainbgm = game.add.audio('mainbgm');
   mainbgm.play();  
   //背景
   background = game.add.image(0, 0, 'background');   
   //按鈕1
   this.btt01 = game.add.button(game.width/2+90, 600, 'game01', this.game1button, this, 0, 2, 1);
   this.btt01.anchor.setTo(0.5, 0.5);
   //按鈕2
   this.btt02 = game.add.button(game.width/2-90, 600, 'game02', this.game2button, this, 0, 2, 1);  
   this.btt02.anchor.setTo(0.5, 0.5);
   //汙泥壓縮長條
   this.game03 = game.add.image(-15 , 350, 'game03');      
   //汙泥1(短)   
   var a = 0; 
   for (var i=0; i<8; i++){          
     this.shortArray[a] = game.add.group();
     this.shortArray[a] = game.add.sprite(-100-i*580, 316, 'game06');
     game.add.tween(this.shortArray[a]).to({ x: "+6000"}, 18000, Phaser.Easing.Linear.None, true);  
     a++;
   }   
   //汙泥2(長)
   this.bit07a = game.add.image(-730-Math.random()*500, 316, 'game07');   
   game.add.tween(this.bit07a).to({ x: "+6000"}, 18000, Phaser.Easing.Linear.None, true);   
   this.bit07b = game.add.image(-1310-Math.random()*200, 316, 'game07');   
   game.add.tween(this.bit07b).to({ x: "+6000"}, 18000, Phaser.Easing.Linear.None, true);   
   this.bit07c = game.add.image(-1560-Math.random()*250, 316, 'game07');   
   game.add.tween(this.bit07c).to({ x: "+6000"}, 18000, Phaser.Easing.Linear.None, true);   
   this.bit07d = game.add.image(-2520-Math.random()*200, 316, 'game07');   
   game.add.tween(this.bit07d).to({ x: "+6000"}, 18000, Phaser.Easing.Linear.None, true);   
   this.bit07e = game.add.image(-2770-Math.random()*250, 316, 'game07');   
   game.add.tween(this.bit07e).to({ x: "+6000"}, 18000, Phaser.Easing.Linear.None, true);
   this.bit07f = game.add.image(-3050-Math.random()*500, 316, 'game07');   
   game.add.tween(this.bit07f).to({ x: "+6000"}, 18000, Phaser.Easing.Linear.None, true);   
   this.bit07g = game.add.image(-3630-Math.random()*500, 316, 'game07');   
   game.add.tween(this.bit07g).to({ x: "+6000"}, 18000, Phaser.Easing.Linear.None, true);         
   //壓縮2
   this.move05 = game.add.image(game.width/2+100, -55.5, 'game05');  
   this.move05.anchor.setTo(0.5, 0.5);
   //壓縮1
   this.move04 = game.add.image(game.width/2+116, -55.5, 'game04');
   this.move04.anchor.setTo(0.5, 0.5);
   //good 
   this.good08 = game.add.image(game.width/2, 500, 'game08');
   this.good08.anchor.setTo(0.5, 0.5);
   this.good08.alpha = 0;
   //great
   this.great09 = game.add.image(game.width/2, 500, 'game09');
   this.great09.anchor.setTo(0.5, 0.5);
   this.great09.alpha = 0;
   //bad
   this.bad10 = game.add.image(game.width/2, 500, 'game10');
   this.bad10.anchor.setTo(0.5, 0.5);
   this.bad10.alpha = 0;
   //perfect
   this.perfect11 = game.add.image(game.width/2, 500, 'game11');
   this.perfect11.anchor.setTo(0.5, 0.5);
   this.perfect11.alpha = 0;      
   //分數   
   var style = {
     font: '40px 微軟正黑體',
     fill: '#FFFFFF',
     align: 'center'}
   this.score = 0;
   this.scoreText = game.add.text(5, 10, '分數：' + this.score, style);
   //時間
   this.timeLeft = 15;
   game.time.events.loop(Phaser.Timer.SECOND, this.decreaseTime, this);      
 },
  
 game1button: function(){
   game.add.tween(this.move04).to({ y: -55.5}, 100, Phaser.Easing.Linear.None, true, 0, 0, true);   
   for (var a=0; a<8; a++){         
     if(this.shortArray[a].x >= 280 & this.shortArray[a].x <= 340){
     // Great，範圍300~340，加4分
         game.sound.play('yes2');   
         this.score=this.score+3;
         this.scoreText.text = '分數：' + this.score;   
         this.great09.alpha = 1;    
         game.add.tween(this.great09).to({ alpha: 0}, 650,Phaser.Easing.Linear.None, true);
         //版本3
         this.game06a = game.add.image(320, 316, 'game06a');
         game.add.tween(this.game06a).to({x: "+600"}, 1800,Phaser.Easing.Linear.None, true); 
         game.add.tween(this.shortArray[a]).to({ x: 4000,alpha: 0}, 300, Phaser.Easing.Linear.None, true);       
         //this.shortArray[a].kill();
         //壓污泥歸位
         game.add.tween(this.move04).to({ y: 140}, 40, Phaser.Easing.Linear.None, true);    
     } else if (this.shortArray[a].x>=240&this.shortArray[a].x<280||this.shortArray[a].x>340 & this.shortArray[a].x<=380){
     // Good，範圍250~300 & 340~380，加2分
         game.sound.play('yes2');   
         this.score=this.score+1;
         this.scoreText.text = '分數：' + this.score;   
         this.good08.alpha = 1;    
         game.add.tween(this.good08).to({ alpha: 0}, 650,Phaser.Easing.Linear.None, true); 
         //版本3
         this.game06a = game.add.image(320, 316, 'game06a');
         game.add.tween(this.game06a).to({x: "+600"}, 1800,Phaser.Easing.Linear.None, true);     
         game.add.tween(this.shortArray[a]).to({ x: 4000,alpha: 0}, 300, Phaser.Easing.Linear.None, true);         
         //this.shortArray[a].kill();
         //壓污泥歸位
         game.add.tween(this.move04).to({ y: 140}, 40, Phaser.Easing.Linear.None, true);   
     } else if (this.shortArray[a].x<240&this.shortArray[a].x>-80 || this.shortArray[a].x>380 &this.shortArray[a].x<500){
     // Bad，範圍外，扣1分
         game.sound.play('no');   
         this.score=this.score-1;
         this.scoreText.text = '分數：' + this.score;
         this.bad10.alpha = 1;    
         game.add.tween(this.bad10).to({ alpha: 0}, 650,Phaser.Easing.Linear.None, true);
         //壓污泥歸位
         game.add.tween(this.move04).to({ y: 140}, 40, Phaser.Easing.Linear.None, true);  
     }
   }    
},
  
 game2button: function(){
   game.add.tween(this.move05).to({ y: -55.5}, 50, Phaser.Easing.Linear.None, true, 0, 0, true);      
   if(this.bit07a.x > 240 & this.bit07a.x < 350){
   // perfect，範圍240~350，加4分
     game.sound.play('no2');   
     this.score=this.score+4;
     this.scoreText.text = '分數：' + this.score;   
     this.perfect11.alpha = 1;    
     game.add.tween(this.perfect11).to({ alpha: 0}, 650,Phaser.Easing.Linear.None, true); 
     //版本3
     this.game07a = game.add.image(280, 316, 'game07a');
     game.add.tween(this.game07a).to({x: "+600"}, 1800,Phaser.Easing.Linear.None, true); 
     game.add.tween(this.bit07a).to({ x: 4000,alpha: 0}, 300, Phaser.Easing.Linear.None, true);  
     //壓污泥歸位
     game.add.tween(this.move05).to({ y: 140}, 40, Phaser.Easing.Linear.None, true);    
   } else if(this.bit07b.x > 240 & this.bit07b.x < 350){
   // perfect，範圍240~350，加4分
     game.sound.play('no2');   
     this.score=this.score+4;
     this.scoreText.text = '分數：' + this.score;   
     this.perfect11.alpha = 1;    
     game.add.tween(this.perfect11).to({ alpha: 0}, 650,Phaser.Easing.Linear.None, true); 
     //版本3
     this.game07b = game.add.image(280, 316, 'game07a');
     game.add.tween(this.game07b).to({x: "+600"}, 1800,Phaser.Easing.Linear.None, true); 
     game.add.tween(this.bit07b).to({ x: 4000,alpha: 0}, 300, Phaser.Easing.Linear.None, true);  
     //壓污泥歸位
     game.add.tween(this.move05).to({ y: 140}, 40, Phaser.Easing.Linear.None, true);       
   } else if(this.bit07c.x > 240 & this.bit07c.x < 350){
   // perfect，範圍240~350，加4分
     game.sound.play('no2');   
     this.score=this.score+4;
     this.scoreText.text = '分數：' + this.score;   
     this.perfect11.alpha = 1;    
     game.add.tween(this.perfect11).to({ alpha: 0}, 650,Phaser.Easing.Linear.None, true); 
     //版本3
     this.game07c = game.add.image(280, 316, 'game07a');
     game.add.tween(this.game07c).to({x: "+600"}, 1800,Phaser.Easing.Linear.None, true); 
     game.add.tween(this.bit07c).to({ x: 4000,alpha: 0}, 300, Phaser.Easing.Linear.None, true);  
     //壓污泥歸位
     game.add.tween(this.move05).to({ y: 140}, 40, Phaser.Easing.Linear.None, true);      
   } else if(this.bit07d.x > 240 & this.bit07d.x < 350){
   // perfect，範圍240~350，加4分
     game.sound.play('no2');   
     this.score=this.score+4;
     this.scoreText.text = '分數：' + this.score;   
     this.perfect11.alpha = 1;    
     game.add.tween(this.perfect11).to({ alpha: 0}, 650,Phaser.Easing.Linear.None, true); 
     //版本3
     this.game07d = game.add.image(280, 316, 'game07a');
     game.add.tween(this.game07d).to({x: "+600"}, 1800,Phaser.Easing.Linear.None, true); 
     game.add.tween(this.bit07d).to({ x: 4000,alpha: 0}, 300, Phaser.Easing.Linear.None, true);  
     //壓污泥歸位
     game.add.tween(this.move05).to({ y: 140}, 40, Phaser.Easing.Linear.None, true);    
   } else if(this.bit07e.x > 240 & this.bit07e.x < 350){
   // perfect，範圍240~350，加4分
     game.sound.play('no2');   
     this.score=this.score+4;
     this.scoreText.text = '分數：' + this.score;   
     this.perfect11.alpha = 1;    
     game.add.tween(this.perfect11).to({ alpha: 0}, 650,Phaser.Easing.Linear.None, true); 
     //版本3
     this.game07e = game.add.image(280, 316, 'game07a');
     game.add.tween(this.game07e).to({x: "+600"}, 1800,Phaser.Easing.Linear.None, true); 
     game.add.tween(this.bit07e).to({ x: 4000,alpha: 0}, 300, Phaser.Easing.Linear.None, true);  
     //壓污泥歸位
     game.add.tween(this.move05).to({ y: 140}, 40, Phaser.Easing.Linear.None, true);      
   } else if(this.bit07f.x > 240 & this.bit07f.x < 350){
   // perfect，範圍240~350，加4分
     game.sound.play('no2');   
     this.score=this.score+4;
     this.scoreText.text = '分數：' + this.score;   
     this.perfect11.alpha = 1;    
     game.add.tween(this.perfect11).to({ alpha: 0}, 650,Phaser.Easing.Linear.None, true); 
     //版本3
     this.game07f = game.add.image(280, 316, 'game07a');
     game.add.tween(this.game07f).to({x: "+600"}, 1800,Phaser.Easing.Linear.None, true); 
     game.add.tween(this.bit07f).to({ x: 4000,alpha: 0}, 300, Phaser.Easing.Linear.None, true);  
     //壓污泥歸位
     game.add.tween(this.move05).to({ y: 140}, 40, Phaser.Easing.Linear.None, true);         
   } else if(this.bit07g.x > 240 & this.bit07g.x < 350){
   // perfect，範圍240~350，加4分
     game.sound.play('no2');   
     this.score=this.score+4;
     this.scoreText.text = '分數：' + this.score;   
     this.perfect11.alpha = 1;    
     game.add.tween(this.perfect11).to({ alpha: 0}, 650,Phaser.Easing.Linear.None, true); 
     //版本3
     this.game07g = game.add.image(280, 316, 'game07a');
     game.add.tween(this.game07g).to({x: "+600"}, 1800,Phaser.Easing.Linear.None, true); 
     game.add.tween(this.bit07g).to({ x: 4000,alpha: 0}, 300, Phaser.Easing.Linear.None, true);  
     //壓污泥歸位
     game.add.tween(this.move05).to({ y: 140}, 40, Phaser.Easing.Linear.None, true);       
   } else {
     //範圍外，錯誤聲音
     game.sound.play('no');  
     this.score=this.score-2;
     this.scoreText.text = '分數：' + this.score;
     this.bad10.alpha = 1;    
     game.add.tween(this.bad10).to({ alpha: 0}, 650,Phaser.Easing.Linear.None, true);
     //壓污泥歸位
     game.add.tween(this.move05).to({ y: 140}, 40, Phaser.Easing.Linear.None, true); 
   }   
 },
  
 decreaseTime: function() {
   this.timeLeft--;   
   if (this.timeLeft==0) {     
      mainbgm.pause();
      game.state.start('wingame');
   }   
 },
};

var easymain = {  
  score: 0,
  scoreText: null,    
  timeLeft: 0,
  shortArray:[],    //短的群組  
  create: function() {
   //音樂
   mainbgm = game.add.audio('mainbgm');
   mainbgm.play(); 
   //背景
   background = game.add.image(0, 0, 'background');   
   //按鈕1
   this.btt12 = game.add.button(game.width/2, 600, 'game12', this.game1button, this, 0, 2, 1);   this.btt12.anchor.setTo(0.5, 0.5);   
   //汙泥壓縮長條
   this.game03 = game.add.image(-15 , 350, 'game03');      
   //汙泥1(短)   
   var a = 0; 
   for (var i=0; i<5; i++){          
     this.shortArray[a] = game.add.group();
     this.shortArray[a] = game.add.sprite(-100-i*580, 316, 'game06');
     game.add.tween(this.shortArray[a]).to({ x: "+5000"}, 20000, Phaser.Easing.Linear.None, true);  
     a++;
   }         
   //壓縮1
   this.move04 = game.add.image(game.width/2+116, -55.5, 'game04');
   this.move04.anchor.setTo(0.5, 0.5);
   //good 
   this.good08 = game.add.image(game.width/2, 500, 'game08');
   this.good08.anchor.setTo(0.5, 0.5);
   this.good08.alpha = 0;
   //great
   this.great09 = game.add.image(game.width/2, 500, 'game09');
   this.great09.anchor.setTo(0.5, 0.5);
   this.great09.alpha = 0;   
   //bad
   this.bad10 = game.add.image(game.width/2, 500, 'game10');
   this.bad10.anchor.setTo(0.5, 0.5);
   this.bad10.alpha = 0;
   //分數   
   var style = {
     font: '40px 微軟正黑體',
     fill: '#FFFFFF',
     align: 'center'}
   this.score = 0;
   this.scoreText = game.add.text(5, 10, '分數：' + this.score, style);
   //時間
   this.timeLeft = 12;
   game.time.events.loop(Phaser.Timer.SECOND, this.decreaseTime, this);   
 },
  
 game1button: function(){
   game.add.tween(this.move04).to({ y: -55.5}, 40, Phaser.Easing.Linear.None, true, 0, 0, true);   
   for (var a=0; a<5; a++){      
     if(this.shortArray[a].x > 300 & this.shortArray[a].x < 340){
     // Great，範圍320~340，加4分
         game.sound.play('yes2');
         this.score=this.score+4;
         this.scoreText.text = '分數：' + this.score;   
         this.great09.alpha = 1;    
         game.add.tween(this.great09).to({ alpha: 0}, 650,Phaser.Easing.Linear.None, true); 
         //版本3
         this.game06a = game.add.image(320, 316, 'game06a');
         game.add.tween(this.game06a).to({x: "+600"}, 1800,Phaser.Easing.Linear.None, true); 
         game.add.tween(this.shortArray[a]).to({ x: 4000,alpha: 0}, 430, Phaser.Easing.Linear.None, true);
         //壓污泥歸位
         game.add.tween(this.move04).to({ y: 140}, 40, Phaser.Easing.Linear.None, true); 
     } else if (this.shortArray[a].x>240&this.shortArray[a].x<300||this.shortArray[a].x>340 & this.shortArray[a].x<380){
     // Good，範圍250~320 & 340~380，加2分
         game.sound.play('yes2');
         this.score=this.score+2;
         this.scoreText.text = '分數：' + this.score;   
         this.good08.alpha = 1;    
         game.add.tween(this.good08).to({ alpha: 0}, 650,Phaser.Easing.Linear.None, true); 
         //版本3
         this.game06a = game.add.image(320, 316, 'game06a');
         game.add.tween(this.game06a).to({x: "+600"}, 1800,Phaser.Easing.Linear.None, true); 
         game.add.tween(this.shortArray[a]).to({ x: 4000,alpha: 0}, 430, Phaser.Easing.Linear.None, true);  
         //壓污泥歸位
         game.add.tween(this.move04).to({ y: 140}, 40, Phaser.Easing.Linear.None, true); 
     } else if (this.shortArray[a].x<240&this.shortArray[a].x>-80 || this.shortArray[a].x>380 &this.shortArray[a].x<500){
         // Bad，範圍外，扣1分
         game.sound.play('no');   
         this.score=this.score-1;
         this.scoreText.text = '分數：' + this.score;
         this.bad10.alpha = 1;    
         game.add.tween(this.bad10).to({ alpha: 0}, 650,Phaser.Easing.Linear.None, true);
         //壓污泥歸位
         game.add.tween(this.move04).to({ y: 140}, 40, Phaser.Easing.Linear.None, true);  
     } 
   }    
},
  
 decreaseTime: function() {
   this.timeLeft--;   
   if (this.timeLeft==0) { 
      mainbgm.pause();      
      game.state.start('winEasy');
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
   var startbg = game.add.image(0, 0, 'startbg');   
   //按鈕
   var goButton = game.add.button(game.width/2, 400,"go", this.startgame, this);
   var setButton = game.add.button(game.width/2, 600,"set", this.setgame, this);
   var allButton = game.add.button(game.width/2, 500,"all", this.allgame, this);
   allButton.anchor.setTo(0.5, 0.5);
   goButton.anchor.setTo(0.5, 0.5);
   setButton.anchor.setTo(0.5, 0.5);
 },  
 startgame: function() {
   game.sound.play('yes');   
   game.state.start('choose');
   titlebgm.pause();
 },
 setgame: function() {      
   game.sound.play('yes');   
   game.state.start('setScreen');  
   titlebgm.pause();
 },
 allgame: function() {   
   titlebgm.pause();   
   window.location="../ranking.php?gameType=05muni";  
 },

};

var wingame = {
 bestscore: 0,  
 firstscore: 0, 
 create: function() {
   //音樂
   winbgm = game.add.audio('winbgm');
   winbgm.play();  
   //背景
   var endbg = game.add.image(0, 0, 'endbg');   
   //最高最低分計算
   this.firstscore = 0;   
   this.firstscore = main.score;
   if (this.firstscore > this.bestscore){
     this.bestscore = this.firstscore;    
   }   
   //文字顯示
   var style = {
     font: '50px 微軟正黑體',
     fill: '#37281c',
     align: 'center'}
   game.add.text(150, 200, '遊戲結束\n '  , style);
   game.add.text(123, 280, '您的分數是\n\n ' , style);
   textnow = game.add.text(game.width/2, 400, main.score , style);
   //game.add.text(150, 400, '最高紀錄\n '  , style);
   //textgood = game.add.text(game.width/2, 505, this.bestscore , style);
   
   textnow.anchor.setTo(0.5, 0.5);
   //textgood.anchor.setTo(0.5, 0.5);   
   
   //將成績傳到html中   
   document.getElementById('score').value=main.score;
   document.getElementById('gameType').value=main.gameType;
   
   //按鈕
   var againbutton = game.add.button(game.width/2, game.height/2+250,"again", this.restartGame, this)
   againbutton.anchor.setTo(0.5, 0.5);
   var updateButton = game.add.button(game.width/2, game.height/2+150,"all2", this.updategame, this);
   updateButton.anchor.setTo(0.5, 0.5);     
 },
  
 restartGame: function() {
   winbgm.pause();
   game.sound.play('no');
   main.shortArray.length = 0;   
   game.state.start('titleScreen');
 },
  updategame: function() {   
   titlebgm.pause();
   game.sound.play('yes');
   scoreForm.submit(); //送出 
   //window.location="../ranking.php";
 },
};

var winEasy = {
 bestEasy: 0,  
 firstEasy: 0, 
 create: function() {
   //音樂
   winbgm = game.add.audio('winbgm');
   winbgm.play();  
   //背景
   var endbg = game.add.image(0, 0, 'endbg');   
   //最高最低分計算
   this.firstEasy = 0;   
   this.firstEasy = easymain.score;
   if (this.firstEasy > this.bestEasy){
     this.bestEasy = this.firstEasy;    
   }   
   //文字顯示
   var style = {
     font: '50px 微軟正黑體',
     fill: '#37281c',
     align: 'center'}
   game.add.text(150, 170, '遊戲結束\n '  , style);
   game.add.text(123, 240, '您的分數是\n ' , style);
   textnow = game.add.text(game.width/2, 350, easymain.score , style);
   game.add.text(150, 400, '最高紀錄\n '  , style);
   textgood = game.add.text(game.width/2, 505, this.bestEasy , style);
   
   textnow.anchor.setTo(0.5, 0.5);
   textgood.anchor.setTo(0.5, 0.5);   
   
   //將成績傳到html中   
   //document.getElementById('score').value=main.score;
   //document.getElementById('gameType').value=main.gameType;
   
   //按鈕
   var againbutton = game.add.button(game.width/2, game.height/2+250,"again", this.restartGame, this)
   againbutton.anchor.setTo(0.5, 0.5);
 },
  
 restartGame: function() {
   winbgm.pause();
   game.sound.play('no');
   main.shortArray.length = 0;   
   game.state.start('titleScreen');
 },
};

var setScreen = {
 create: function() {
   //背景
   game.add.image(0, 0, 'setbg');   
   //圖解
   var set01 = game.add.image(game.width/2, 350, 'set01');  
   set01.anchor.setTo(0.5, 0.5);
   //按鈕
   var gobackButton = game.add.button(game.width/2+80, 600,"goback", this.backGame, this);
   gobackButton.anchor.setTo(0.5, 0.5);
 },
  
 backGame: function() {
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
game.state.add('titleScreen', titleScreen);
game.state.add('setScreen', setScreen);
game.state.add('choose', choose);
game.state.add('main', main);
game.state.add('wingame', wingame);
game.state.add('easymain', easymain);
game.state.add('winEasy', winEasy);
game.state.add('Preloader', Preloader);
game.state.add('Boot', Boot);
game.state.start('Boot');
