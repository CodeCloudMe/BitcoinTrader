onPageCount = 0;
var allLinks=[];
hardLimit = 2;
siteCounter=0;
 var allTheLinks=[];
majorLimit = 1;


theTopic='';




 var allTheEmails= [];
function getCertainPages(keyword, limit){

    theTopic=keyword;
    majorLimit=limit;
    var waitTime = limit*16000;
    activeEmailCatch(waitTime);

    onPageCount = 0;
    allLinks=[];
    var starter = 1;
    for(i=0; i<limit; i++){
            starter= starter+10;
            var postUrl ='http://www.bing.com/search?q='+encodeURIComponent(keyword)+"&first="+starter;
             download(postUrl, function(data) {
            // jsdom.env(
                 /// "http://www.bing.com/search?q="+encodeURIComponent(keyword)+"&first="+starter,
                 /// ["http://code.jquery.com/jquery.js"],
                 // function (errors, window) {

                    try{
                       var $ = cheerio.load(data);
                   // $=window.$;
                   // console.log("there have been", $("a").length, "links on  releases!");

                    $('a').each(function(){
                       // console.log('get links' +$('a').length+" count");

                        try{
                            if($(this).attr('href').indexOf("http")!=-1 && $(this).attr('href').indexOf("microsof") == -1  && $(this).attr('href').indexOf("bing") == -1 ){


/*
                       siteCounter=siteCounter+1;
                       if(siteCounter>=hardLimit){

                        return false;
                       }

*/
                            allLinks.push($(this).attr('href'));


                            console.log($(this).attr('href'));

                            var tLink = $(this).attr('href');
                            console.log("tlink="+tLink);
                            var hoster = tLink.split('/')[2];
                            var linker = tLink.split(hoster)[1];
                             console.log('linker and hoster');
                            console.log(hoster);
                            console.log(linker);

                            if(hoster.length < 7 || linker <7 || hoster.indexOf('<')!=-1){
                                return;
                            }
                              var options = {
                host: hoster,
                path: linker
                };

                http.get(options, function (http_res) {
                  //  console.log(http_res);
                   // return;
                   try{

                 var data = "";

                // this event fires many times, each time collecting another piece of the response
                http_res.on("data", function (chunk) {
                    // append this chunk to our growing `data` var
                    data += chunk;
                });

                // this event fires *one* time, after all the `data` events/chunks have been gathered
                http_res.on("end", function () {
                    // you can use res.send instead of console.log to output via express
                   
                    //console.log(data);
                    findAllLinks(data, hoster);
                   //bitResp= data;
                    //btcGlobResp.send(bitResp);


                 });
}

catch(err1){

    console.log("2"+err1);
}
            }, hoster)



                            }
                        }

                          catch(err){

                            console.log("weird")
                            console.log(err);
                          }

                        
                     


                    })


                   

                   onPageCount= onPageCount+1;
                   console.log(onPageCount);
                   if(onPageCount == limit){
                         // console.log(allLinks);

                   }







}
catch(err){

    console.log("1"+err);
}
                  }
                );

    }
  

    //return array of all the links
}


function saveEmails(theTime){

    theTime= theTime*majorLimit;

  setTimeout(function(){

     emailResp.send(JSON.stringify(allTheEmails));
  }, theTime)
}

function findAllLinks(html, domain){

        saveEmails(60000);

        var intLinks = html.split('href="');
        var realLinks = [];
        for(z in intLinks){

            var thisLinks = intLinks[z].split('"');

            if(thisLinks[0].indexOf("http")!=-1){
                //does have.... don't do shit
                var itPage = thisLinks[0];
            }
            else{
                 var itPage= "http://"+domain+ thisLinks[0] ;
            }
            
          
                console.log("think this is right: "+itPage);
                if(itPage.length > 10){
                    allTheLinks.push(itPage);
                }
                


        }


      //  console.log('hey');
      //  console.log(domain);


}

function activeEmailCatch(thePeriod){


    setTimeout(function(){
console.log('going to find email addresses');
        for(f in allTheLinks){

            try{
                     findAllEmails(allTheLinks[f]);
            }

            catch(err){

                console.log("5"+err);
            }
       
        }

    }, thePeriod)
}


function findAllEmails(site){

              try{
    
                            var hoster = site.split('/')[2];
                            var linker = site.split(hoster)[1];
                             

                             if(hoster.length<7 || linker.length <7 || hoster.indexOf('http')!=-1 || hoster.indexOf('simply')!=-1 || hoster.length > 50 || linker.length >50){

                                 console.log(hoster);
                            console.log(linker);
                                console.log("stop email");
                                return false;
                             }

                             if(linker.indexOf("/")!=0){
                                console.log("bad"+ linker)
                                return false;
                             }

                            console.log("good:"+hoster);
                            console.log("good"+linker);
                            //console.log()

                              var options = {
                host: hoster,
                path: linker
                };

               pleaseWork= http.get(options, function (http_res) {
                  //  console.log(http_res);
                   
                 


                   try{
                    console.log('getting email');
                 var data = "";

           
                // this event fires many times, each time collecting another piece of the response
                http_res.on("data", function (chunk) {
                    // append this chunk to our growing `data` var
                    try{
                         data += chunk;
                    }
                    catch(err){
                        console.log(err);
                    }
                   
                });

                // this event fires *one* time, after all the `data` events/chunks have been gathered
                http_res.on("end", function () {
                    // you can use res.send instead of console.log to output via express
console.log('gots page for email');
                    try{
                   var matches = data.match(/(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))/g);
console.log('atches part');
                    if(matches!=null){

                        for(p in matches){
                         var dontAdd=false;
                            if(matches[p].indexOf('@')!=-1){
                              
                                for(z in allTheEmails){

                                  if(allTheEmails[z]==matches[p]){
                                    dontAdd=true;
                                  }
                                }

                                
                                if(dontAdd==false){
                                  allTheEmails.push(matches[p]);

                                  addToDBE(matches[p], theTopic);
                                }
                                 
                            }
                           
                        }

                        console.log(allTheEmails);
                        
                    }

}

catch(err){

    console.log(4);
}

                })




}
catch(err){
    console.log("3"+err);
}
            })

 pleaseWork.on("error", function(err){


                        console.log('error in plwrk');
                    })


}

catch(err4){

    console.log("4"+err4);
}

            }
function addToDBE(emailA, topicA){

          var options = {
                host: 'alan-maybe588.rhcloud.com',
                path: '/cloud/models/requests/emaillist.php?email='+emailA+'&topic='+encodeURIComponent(topicA)
                };

                comeOnPlease =  http.get(options, function (http_res) {

               
                console.log('saved to good');


               });


               console.log('saved to db?');
                  //  console.log(http_res);
               
               comeOnPlease.on("error", function(err){


                        console.log('could not save to db');
                    })    
                 

}

