#!/bin/env node
//  OpenShift sample Node application
var express = require('express');
var fs      = require('fs');
var sentiment = require('sentiment');
var http = require('http');
var cheerio = require("cheerio");

synaptic= require('synaptic');
var Bitstamp = require('bitstamp');
//var assert = require('assert');
//var NeuralNetwork = require('neural_network');

//var nn = new NeuralNetwork();

eval(fs.readFileSync('./lib/whattime/index.js', 'utf8')); 
eval(fs.readFileSync('./lib/bitcoin/index.js', 'utf8')); 

eval(fs.readFileSync('./lib/mailing/index.js', 'utf8')); 

eval(fs.readFileSync('./lib/prediction/index.js', 'utf8')); 

eval(fs.readFileSync('./lib/trading/index.js', 'utf8')); 



var natural = require('./lib/natural/'),
    classifier = new natural.BayesClassifier();


/**
 *  Define the sample application.
 */
var SampleApp = function() {

    //  Scope.
    var self = this;


    /*  ================================================================  */
    /*  Helper functions.                                                 */
    /*  ================================================================  */

    /**
     *  Set up server IP address and port # using env variables/defaults.
     */
    self.setupVariables = function() {
        //  Set the environment variables we need.
        self.ipaddress = process.env.OPENSHIFT_NODEJS_IP;
        self.port      = process.env.OPENSHIFT_NODEJS_PORT || 8080;

        if (typeof self.ipaddress === "undefined") {
            //  Log errors on OpenShift but continue w/ 127.0.0.1 - this
            //  allows us to run/test the app locally.
            console.warn('No OPENSHIFT_NODEJS_IP var, using 127.0.0.1');
            self.ipaddress = "127.0.0.1";
        };
    };


    /**
     *  Populate the cache.
     */
    self.populateCache = function() {
        if (typeof self.zcache === "undefined") {
            self.zcache = { 'index.html': '' };
        }

        //  Local cache for static content.
        self.zcache['index.html'] = fs.readFileSync('./index.html');
    };


    /**
     *  Retrieve entry (content) from cache.
     *  @param {string} key  Key identifying content to retrieve from cache.
     */
    self.cache_get = function(key) { return self.zcache[key]; };


    /**
     *  terminator === the termination handler
     *  Terminate server on receipt of the specified signal.
     *  @param {string} sig  Signal to terminate on.
     */
    self.terminator = function(sig){
        if (typeof sig === "string") {
           console.log('%s: Received %s - terminating sample app ...',
                       Date(Date.now()), sig);
           process.exit(1);
        }
        console.log('%s: Node server stopped.', Date(Date.now()) );
    };


    /**
     *  Setup termination handlers (for exit and a list of signals).
     */
    self.setupTerminationHandlers = function(){
        //  Process on exit and signals.
        process.on('exit', function() { self.terminator(); });

        // Removed 'SIGPIPE' from the list - bugz 852598.
        ['SIGHUP', 'SIGINT', 'SIGQUIT', 'SIGILL', 'SIGTRAP', 'SIGABRT',
         'SIGBUS', 'SIGFPE', 'SIGUSR1', 'SIGSEGV', 'SIGUSR2', 'SIGTERM'
        ].forEach(function(element, index, array) {
            process.on(element, function() { self.terminator(element); });
        });
    };


    /*  ================================================================  */
    /*  App server functions (main app logic here).                       */
    /*  ================================================================  */

    /**
     *  Create the routing table entries + handlers for the application.
     */
    self.createRoutes = function() {
        self.routes = { };


       
    };


    /**
     *  Initialize the server (express) and create the routes and register
     *  the handlers.
     */
    self.initializeServer = function() {
        self.createRoutes();
        self.app = express.createServer();
        self.app.use(express.bodyParser());


      

       self.routes['/asciimo'] = function(req, res) {
            var link = "http://i.imgur.com/kmbjB.png";
            res.send("<html><body><img src='" + link + "'></body></html>");
        };

        self.routes['/'] = function(req, res) {
            res.setHeader('Content-Type', 'text/html');
            res.send(self.cache_get('index.html') );
        };



         self.routes['/tradeb'] = function(req, res) {
           





            bT1 = new tradeB();
            bT1.startIt(  250159, 'FmlpbSxkdGxf66snq42uFOM7yp6rz2Jx','6R9uJIbT0sIlKH7Pa1F3Y3jDNnv4UEVY', bT1);
            

            res.setHeader('Content-Type', 'text/html');
            res.send(JSON.stringify({'status':'success'}));
        };






























        //  Add handlers for the app for posts... (from the routes).
              for (var r in self.routes) {
                  self.app.get(r, self.routes[r]);
                  self.app.post(r, self.routes[r]);
              }
                  self.app.use(function(req, res, next) {
                    req.socket.on("error", function() {

                    });
                    res.socket.on("error", function() {

                    });
                    next();
                });
    };


    /**
     *  Initializes the sample application.
     */
    self.initialize = function() {
        self.setupVariables();
        self.populateCache();
        self.setupTerminationHandlers();

        // Create the express server and routes.
        self.initializeServer();
    };


    /**
     *  Start the server (starts up the sample application).
     */
    self.start = function() {
        //  Start the app on the specific interface (and port).
        self.app.listen(self.port, self.ipaddress, function() {
            console.log('%s: Node server started on %s:%d ...',
                        Date(Date.now() ), self.ipaddress, self.port);
        });
    };

};   /*  Sample Application.  */



/**
 *  main():  Main code.
 */
var zapp = new SampleApp();
zapp.initialize();
zapp.start();




function download(url, callback) {
  http.get(url, function(res) {
    var data = "";
    res.on('data', function (chunk) {
      data += chunk;
    });
    res.on("end", function() {
      callback(data);
    });
  }).on("error", function() {
    callback(null);
  });
}


function download2(url, callback, cbData) {
  http.get(url, function(res) {
    var data = "";
    res.on('data', function (chunk) {
      data += chunk;
    });
    res.on("end", function() {
      callback(data, cbData);
    });
  }).on("error", function() {
    callback(null);
  });
}


Date.prototype.addHours= function(h){
    this.setHours(this.getHours()+h);
    return this;
}




//example trade function for trade performance




            tradeB = function(){

              //this.init();

              this.apiKey = "";
              this.apiSecret= "";


              //between 1 and 10
              this.riskTolerance =5;

              this.publicBitstamp= new Bitstamp();

              this.openOrderId = 0;

              this.amount =0;
              //unset... will be set upon setCred

              this.privateBitstamp =[];

              this.percentWant= .012;

              this.percentWaitToSell = .011;
              //max time to hold sell position before sell
              this.limitSellTime = 1540;



              this.waitPriceThreshold = 0;

              this.minimumDollarReserve =300;


              this.maxBTC = .1;


              this.stopLoss = .02;

              //set to false for script to run
              this.bleeding= true;
              this.init= function(){

               

            //  publicBitstamp.transactions({time: 'hour'}, console.log);
             // publicBitstamp.ticker(console.log);
              ///publicBitstamp.order_book(false, console.log);
              //publicBitstamp.bitinstant(console.log);
             // publicBitstamp.eur_usd(console.log);

             // your Bitstamp user ID
              
              //privateBitstamp.balance(console.log);
                // global return... worry bout this later


              }


              this.getTradeHistory = function (){


              }

              this.getRiskTolerance= function(){


              }


              this.startIt= function(clientId, apiKey, apiSecret, obj){

                this.apiKey = apiKey;
                this.apiSecret = apiSecret;
                this.privateBitstamp = new Bitstamp(apiKey, apiSecret, clientId);
                this.publicBitstamp = new Bitstamp();
               // console.log('s');
               console.log(this.apiKey);
                this.privateBitstamp.balance(function(){obj.getInfo(obj)});


              }

              this.buyOrder= function(amount, price){


              }

              this.sellOrder = function(amount, price){


              }

              this.getInfo = function (obj){

                if(obj.bleeding==true){

                  console.log("bleeding set to true... stopping this shit show now");
                  return;
                }


               // console.log(obj.apiKey)
                obj.privateBitstamp.open_orders(function(balance, data){

                 obj.getStatus(data, obj)
               } );

              }


              this.getStatus= function(info, obj){
                console.log('open orders is');



                console.log(info);
                
                if(!info[0]){
                  console.log('no orders open...');

                  obj.privateBitstamp.balance(function(info, data1){

                    //get price ifo and send them to determine

                     obj.publicBitstamp.ticker(function(info, data){

                          obj.determineIfBuy(data, obj, data1);

                     });
                  

                  })
                  //no open order...
                  //here we should check if we're in range...
                  //when we are in range, then we check to see if it's time to place order
                }

                else if(info[0]['type']==1){


                   obj.waitPriceThreshold= parseFloat(info[0]['price']);
                   var thresh = obj.waitPriceThreshold *(obj.percentWant/2);
                   obj.waitPriceThreshold= (obj.waitPriceThreshold- thresh).toFixed(2);

                   
                  this.openOrderId = info[0]['id'];
                  console.log('sell btc order open... at '+ info[0]['price'] + '... want  to sell '+ info[0]['amount'] );
                  var blah = []
                  obj.publicBitstamp.ticker(function(blah, curData){
                      obj.privateBitstamp.user_transactions(function(info, data){

                     obj.pendingSell(data[0], obj,curData);

                  })

                  })
                 
                  //you have sell btc order
                }

                else{
                    this.openOrderId = info[0]['id'];
                  console.log('buy btc order open... at '+ info[0]['price'] + '... want to buy '+ info[0]['amount'] );
                  //you have buy order
                  var blah = []
                  obj.publicBitstamp.ticker(function(blah, curData){
                   obj.privateBitstamp.user_transactions(function(info, data){

                    obj.pendingBuy(data[0], obj, curData);

                  })

                 });
                }


                // this is fdifferent from the getInfo because its focused on our interanls and how this script works
              }

              this.determineIfBuy= function(transData, obj,data1){
                console.log('determine if buy function');
                console.log(transData);
               console.log(data1['usd_balance']);
               console.log(data1);
                //usd we have
                obj.amount = parseFloat(data1['usd_balance'])- (parseFloat(data1['usd_balance'])*.01);





                //check if you exceed max btc, if you do.... dont' do below. Instead, sell your remaining btc

                if(parseFloat(data1['btc_balance']) > obj.maxBTC){

                   var realAmount= parseFloat(data1['btc_balance']);
                   var priceWant =  (parseFloat(transData['ask'])+ (parseFloat(transData['ask']) *obj.percentWant)).toFixed(2);
                      console.log("want to sell" + realAmount+" BTC at "+ priceWant +"boom" ); 

                  // we're gonna do a buy and return
                        obj.privateBitstamp.sell(realAmount,priceWant, function(r, transData1){

                        console.log(transData1);
                        console.log('you have bitcoin, so were selling it at higher price');
                 

                    });

                  return;
                }

                //if amount is less than minimum $ reserve...


                //get ask and place buy order at .1% lower than ask
                console.log("amount is "+ obj.amount);
                if(obj.amount < obj.minimumDollarReserve){

                  var lowerThanBidPrice = (parseFloat(transData['bid']) - parseFloat(transData['bid']*.0015)).toFixed(2);

                var realAmount=  (obj.minimumDollarReserve * (1/parseFloat(transData['bid']))).toFixed(2);

                console.log("want to buy" + realAmount+" BTC at "+ lowerThanBidPrice ) 

                  // we're gonna do a buy and return
                  obj.privateBitstamp.sell(realAmount, lowerThanBidPrice, function(r, transData1){

                    console.log(transData1);
                  console.log('we didnt have the reserve available... trying to buy');
                 

                    });

                  return;
                }



                var ratio = parseFloat(1/transData['ask']);

                obj.amount = (obj.amount * ratio).toFixed(2);
                console.log('amount ='+ obj.amount);


                //get differnce between low and high
                var high = parseFloat(transData['high']);
                var low = parseFloat(transData['low']);
                var ask= parseFloat(transData['ask']);
                 var bid= parseFloat(transData['bid']);


                var differ = high-low;


                 var twentyP = differ*.15;

                var lowTwenty = low+twentyP;
                var highTwenty = high - twentyP;

                if(ask < lowTwenty){

                     console.log("in buy range... above " + lowTwenty+" and we dont care about it being anymore below... cause we like rallies: "+ highTwenty + "at " + ask);
                  

                  console.log('about to see if the spread is low... .997');
                  var spread = bid/ask;
                  console.log("spread is "+ spread);

                  if(spread> .998){
                    console.log("run AI!!!");
                     obj.runOnBuySellProxy(transData, obj);
                    //spread is low!
                  }
                  else{


                    console.log("not running... spread is too great");
                  }



                  


                  //console.log('check ')

                 

                }

                else{
                  console.log("NOT in buy range... between " + lowTwenty+" and "+ highTwenty + "at " + ask);

                }
                //say it's 5

                //get 20% of difference from low and 20% from high

                //if it's in this sweet spot, then run AI


              }






                    this.determineIfBuyRiding= function(data1, obj,transData){
                console.log('determine if buy riding function');
                console.log(transData);
               console.log(data1['usd_balance']);
               console.log(data1);
                //usd we have
                var ratio = parseFloat((1/parseFloat(transData['ask'])));
                console.log("ratio is "+ ratio);
                console.log(obj.minimumDollarReserve);
                var mini = obj.minimumDollarReserve - (obj.minimumDollarReserve *.015);
                console.log("mini is "+ mini);
                obj.amount = (mini * ratio).toFixed(2);





                //check if you exceed max btc, if you do.... dont' do below. Instead, sell your remaining btc

    

                //if amount is less than minimum $ reserve...


                //get ask and place buy order at .1% lower than ask
        



                
                console.log('amount ='+ obj.amount);


                //get differnce between low and high
                var high = parseFloat(transData['high']);
                var low = parseFloat(transData['low']);
                var ask= parseFloat(transData['ask']);
                 var bid= parseFloat(transData['bid']);


                var differ = high-low;


                var twentyP = differ*.25;

                var lowTwenty = low+twentyP;
                var highTwenty = high - twentyP;

                if(ask < lowTwenty){

                     console.log("in buy range... below " + lowTwenty+" and we dont care about it being anymore below... cause we like rallies: "+ highTwenty + "at " + ask);
                  

                  console.log('about to see if the spread is low... .997');
                  var spread = bid/ask;
                  console.log("spread is "+ spread);

                  if(spread> .9975){
                    console.log("run cancel order and buy!!!");
                     
                    //run a cancel -> callback is sell order
                    console.log('cancelling oder '+obj.openOrderId);
                      obj.privateBitstamp.cancel_order(obj.openOrderId, function(){

                      console.log('cancelled rising sell order... about to set higher sell');

                      obj.privateBitstamp.sell(obj.amount, (parseFloat(transData['ask'])+ (parseFloat(transData['ask']) *obj.percentWaitToSell)).toFixed(2), console.log);

                     // var sellPrice = currentBid.toFixed(2);

                       // obj.afterCancelSellSave(sellPrice, obj );
                     });



                    //spread is low!
                  }
                  else{


                    console.log("not running... spread is too great... not riding");
                  }



                  


                  //console.log('check ')

                 

                }

                else{
                  console.log("NOT in buy range... between " + lowTwenty+" and "+ highTwenty + "at " + ask);

                }
                //say it's 5

                //get 20% of difference from low and 20% from high

                //if it's in this sweet spot, then run AI


              }



              this.runOnBuySellProxy = function(transData, obj){

                console.log("running proxy");
                //http://nodejs-maybe588.rhcloud.com/thinkBitcoin
                download2("http://nodejs-maybe588.rhcloud.com/thinkBitcoin", function(servResp){
                 
                 console.log(servResp);
                 // var theResp = JSON.parse(servResp);
                  //console.log(theResp);

                 // if(theResp['status']=="fail"){
                   // console.log('not a good time to buy');
                 // }
                 // else{
                    console.log('good time to buy');
                    obj.runOnBuySell(transData, obj);
                 // }
                  


                }, obj)
              }

              this.runOnBuySell = function(transData, obj){
                var r = [];
                console.log('starting buy order');
                //price 

                //buy price 
               var buyAmount =  (Math.abs((parseInt(obj.minimumDollarReserve))) * (1/parseFloat(transData['ask']))).toFixed(2);
               console.log(buyAmount);
                obj.privateBitstamp.buy(buyAmount, parseFloat(transData['ask']), function(r, transData1){

                  console.log('finished buy (bout to sell) order...');
                  obj.runOnBuySellPart2(transData, obj);

                });



              


              }

              this.runOnBuySellPart2= function(transData, obj){

                    obj.privateBitstamp.sell(obj.amount, (parseFloat(transData['ask'])+ (parseFloat(transData['ask']) *obj.percentWant)).toFixed(2), console.log);


              }

               this.pendingBuy= function(transData, obj){

                
                //failed. ... open sell order at 1% from here
                console.log(transData);
                 console.log(curData);

                 console.log('pending buy function... about to cancel so we reset');

                  obj.privateBitstamp.cancel_order(obj.openOrderId, obj.tellCancel);


              }

              this.pendingSell= function( transData, obj, curData){

                console.log('pending sell function');
                console.log(curData);

                var currentBid = parseFloat(curData['bid']);

                console.log(transData);

                //want sell price is actually price you bought it at.
                console.log('want sell price is '+transData['btc_usd']);
                var wantSellPrice = parseFloat(transData['btc_usd']);
                console.log('want sell price is '+wantSellPrice);

                var stopLoss = obj.stopLoss;

             //  test 0
                console.log("stop loss percent is "+ stopLoss);

                var panicPrice  = (wantSellPrice-(wantSellPrice*stopLoss)).toFixed(2);
                 console.log('panic price is '+ panicPrice+ ", while bid is "+ currentBid+"and we bought at" + wantSellPrice);
             
              console.log("usd amount is "+ Math.abs((parseInt(transData['usd']))));
              var amount=  (Math.abs((parseInt(transData['usd']))) * (1/parseFloat(transData['btc_usd']))).toFixed(2);
              console.log('amount is'+ amount);
             //   var amount = parseFloat(curData['amount']);

                var panicPrice1 = (currentBid - (currentBid*.011)).toFixed(2);
                if(currentBid < panicPrice){
                  console.log("panicking... Panic price was "+ panicPrice+", and the current bud is "+ currentBid);
                  
                    obj.privateBitstamp.cancel_order(obj.openOrderId, function(){

                      console.log('cancelled bad sell order');
                     // var sellPrice = currentBid.toFixed(2);

                       // obj.afterCancelSellSave(sellPrice, obj );
                     });


                  obj.panicSell(panicPrice1, amount, obj);
                  return;
                }

                //see if we're 90% there... if we are, then maybe cancel sell order if

                var priceBought = parseFloat(transData['btc_usd']);
                var ninetyPercent = priceBought+ (priceBought * obj.percentWaitToSell);
                console.log("ninety percent is set to "+ninetyPercent);
               
                /*
                if(priceBought> ninetyPercent){

                  
                  //wait to sell there is a buy
                  obj.determineIfBuyRiding(transData, obj, curData);

                  return;
                }

                */



                //do it by time... if order hasn't been filled in 3 hours... cancel.

                var today = new Date();
                today = today.addHours(5);
                var timeOfTrade = new Date(transData['datetime'] );
                var diffMs = (timeOfTrade - today ); // milliseconds between now & Christmas
                console.log('listening to you....');
                console.log(diffMs);

                console.log(today);

                console.log(timeOfTrade);

                var secondsDiff = diffMs/1000;
                 var diffMinutes = secondsDiff/60;
                 diffMinutes = Math.abs(diffMinutes);


                 console.log('minutes!'+ diffMinutes);

                 diffMinutes =parseInt( diffMinutes);
                var diffMins = Math.round(((diffMs % 86400000) % 3600000) / 60000); // minutes

                diffMins = Math.abs(diffMins);

                diffMins = diffMinutes;
                console.log(diffMins);

                console.log('the wait cancel sell number is if too long is '+obj.waitPriceThreshold);

                //if time is higher and half of want is met, cancel and sell...


                var halfSellTime = obj.limitSellTime/2;
                if(halfSellTime < diffMins){

                  console.log('its been a while but price hasnt hit but we can sell at profit');
                   if(currentBid > obj.waitPriceThreshold){


                     obj.privateBitstamp.cancel_order(obj.openOrderId, function(){

                      var sellPrice = currentBid.toFixed(2);
                        obj.afterCancelSellSave(currentBid.toFixed(2), obj );
                     });


                   }
                }


               if(obj.limitSellTime< diffMins){


                //selll.... return

                //just gonna sell at bid

                    obj.privateBitstamp.cancel_order(obj.openOrderId, function(){

                          var sellPrice = currentBid.toFixed(2);
                          console.log(sellPrice);
                          var sellAmount =  (obj.minimumDollarReserve * (1/parseFloat(sellPrice))).toFixed(2)
                          obj.privateBitstamp.sell(sellAmount, sellPrice, function(r, transData){

                        console.log(transData);
                      console.log('time was up so we sold were selling that shit at'+ sellPrice );
                     

                        });
                   });

                   return;






                //code below doesn't run... bad assumption but keeping fucked up code



                if(currentBid > obj.waitPriceThreshold){
                  //wait!





                  if(obj.limitSellTime*2.5 < diffMins){

                          console.log('its been like 7+ hours'+ obj.openOrderId);
                      obj.privateBitstamp.cancel_order(obj.openOrderId, obj.tellCancel);

                  }
                  else{

                    console.log('its been 3 hours... but were going to wait up to 9 because price is moving up... not anymore... were going to cancel order and place sell order at the bid price, cause you still profit... price to cut losses');
                    //if the bid is greater than .06, then we should sell at a profit 
                     obj.privateBitstamp.cancel_order(obj.openOrderId, function(){

                      var sellPrice = currentBid.toFixed(2);
                        obj.afterCancelSellSave(sellPrice, obj );
                     });


                  }
                  


                }

                else{

                  //just sell and reset

                  //current bid is lower than the threshold were willing to wait... cancel!
                  console.log('current bid is lower than the threshold were willing to wait... cancel!... been 3 hours');
                    console.log('order id is'+ obj.openOrderId);
                  obj.privateBitstamp.cancel_order(obj.openOrderId, obj.tellCancel);

                }
                //see if price has moved up .3... go to triple time... if it's triple time sell



              
               }

               else{

                console.log('holding... finished sell go');
               }
           
                // obj.test();



              }

              this.panicSell=function(curBid, amount, obj){


                obj.privateBitstamp.sell(amount, curBid, function(r, transData1){

                    console.log(transData1);
                  console.log('price dropped and we sold.. or are waiting to sell at a loss');
                 

                    });

              }

              this.afterCancelSellSave= function(price, obj){

                  var realAmount=  (obj.minimumDollarReserve * (1/parseFloat(price))).toFixed(2);

                  console.log("want to sell " + realAmount+" BTC at "+ price ) ;

                  // we're gonna do a buy and return
                  obj.privateBitstamp.sell(realAmount, price, function(r, transData1){

                    console.log(transData1);
                  console.log('just tried trying to save your ass');
                 

                    });
              }

              this.tellCancel=function(info, data){
                console.log(data);
                console.log('cancelled');
              }

              


              this.test = function(){

                console.log(this.apiKey);
              }






            }

            





