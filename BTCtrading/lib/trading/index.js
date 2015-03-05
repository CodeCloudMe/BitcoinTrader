function trader(key1, secret1, client_id1, amount1){


    //

    this.amount1 = amount1;
    this.key1= key1;
    this.secret1 = secret1;
    this.client_id1 = client_id1;


     var publicBitstamp = new Bitstamp();

    //  publicBitstamp.transactions({time: 'hour'}, console.log);
     // publicBitstamp.ticker(console.log);
      ///publicBitstamp.order_book(false, console.log);
      //publicBitstamp.bitinstant(console.log);
     // publicBitstamp.eur_usd(console.log);

     // your Bitstamp user ID
      privateBitstamp = new Bitstamp(key1, secret1, client_id1);

     privateBitstamp.balance(console.log);


     //indicator for then to trade
     this.checkBenchMark = function(){


        //check to see if anything is not active. If not

        //run neaural net here and if neural net says its a good time to buy, run following, otherwise return not ready yet

        
        download2('http://btc-maybe588.rhcloud.com/cloud/models/btc/checkBenchMark.php?id='+this.client_id1, this.checkBenchCB, {'id':this.client_id1, 'amount':this.amount1, 'obj':this} );


     }

     this.checkBenchCB = function(theData, theData1){

        theData = JSON.parse(theData);
        if(theData['active']=='false'){


            if(!theData['bidWaiting']){


                console.log('waiting');

                 bitTradeResp.send(JSON.stringify({'status':'success', 'msg':'active is false, but were waiting. Should happen only once'}))

            }
            else{
                console.log(theData);
                var buyPrice= parseFloat(theData['buyPrice']);

                theData1.obj.sellPrice = parseFloat(theData['bidWaiting']);
                console.log('buying this much: '+ theData1.obj.amount1 + 'at ' + buyPrice );

                privateBitstamp.buy(theData1.obj.amount1, buyPrice, console.log);


                setTimeout(function(){
                    //setting sell order

                    console.log('selling order for '+ theData1.obj.amount1 + ' at '+ theData1.obj.sellPrice.toFixed(2));

                    privateBitstamp.sell(theData1.obj.amount1, theData1.obj.sellPrice.toFixed(2), console.log);
                    setTimeout(function(){

                          bitTradeResp.send(JSON.stringify({'status':'success', 'msg':'placed sell order at  ' + theData1.obj.sellPrice }))
                    }, 2000, theData1);
                    


                }, 10000, theData1);
                


            }
            
            //create the buy order
            //get price that's 2 percent higher

            //update database

        }

        else{

            console.log('we are active... waiting');
             bitTradeResp.send(JSON.stringify({'status':'success', 'msg':'waiting for price at' +theData['waitingFor']}))
        }
        /*
        else{

             download2('http://btc-maybe588.rhcloud.com/cloud/models/btc/isItTime1.php?id='+theData['obj'].client_id1, theData['obj'].doABenchBuy, {'id':theData['obj'].client_id1, 'amount':theData['obj'].amount1, 'obj':theData['obj']} );
            //check for the right price...
            //if the price is high enough, sell
        }

        */

     }

     this.doABenchBuy= function(respData, theData){

        respData= JSON.parse(respData);
        if(respData['buy']=="true"){


            console.log('buy code goes here');
        }
        else{
            console.log('its not time yet');
        }

     }

     this.checkSmart = function(){

        
     }


}