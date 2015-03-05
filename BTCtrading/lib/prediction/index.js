var neuralN = function(benchmark, inputUrls, changeFind, startDate, endDate, tick, settings, callback){

//benchmark is what were looking through the inputs to find patterns in.... bencmark data can be included input.


	this.benchMarkData=[];
	console.log('inputur='+inputUrls);
	//try{
		//this.inputUrls = JSON.parse(inputUrls);
	//}

	//catch(err){
		//console.log('inputUrls is not an array')
		this.inputUrls = inputUrls;
	//}
	
	this.changeFind= changeFind;
	this.benchmark = benchmark;

    this.tick = tick;

    this.startDate= startDate;
    this.endDate= endDate;
	//console.log(this.benchmark);
	this.settings = settings;
	this.whichUrl=0;

    this.orderedResponse=[];


	//contains data of inputUrls

	this.dataContent = [];

	this.findPatterns= function(){

		var allBestCorr= [];

        for(k in this.benchMarkData){
            this.benchMarkData[k]= parseFloat(this.benchMarkData[k]);
        }

		//console.log(this.benchmark);

        var theCount = 0;
		for(i in this.dataContent){


            for(j in this.dataContent[i]){
                this.dataContent[i][j]= parseFloat(this.dataContent[i][j]);
            }
			//goes up to 40 mins
			var bestCorr = this.outwayCorr(this.benchMarkData, this.dataContent[i], 40 );
			//compare dataContent[i] with  benchmarkData
          // console.log(this.orderedResponse);
           var onThis = parseInt(i);
           //console.log(onThis);
        //  console.log( this.orderedResponse[1]);
            var whichOn = this.orderedResponse[theCount];
            console.log(whichOn);
            var thisResp = {};
            thisResp[whichOn]= bestCorr;
			allBestCorr.push(thisResp)

            theCount=theCount+1;

		}

		//cycle through all best correlations and find test them
		//now we know where best correaltions are... find the highest 1, run a fake trades on it for testing
		console.log("all best correations coming as array in order of data you sent. Trading decisions will be based on these correlations");
		console.log(allBestCorr);

	}


	this.processBenchMark=function(benchMarkData, obj){
		//console.log(benchMarkData);
		obj.benchMarkData = benchMarkData;
        console.log('benchmark data...');
       // console.log(benchMarkData);
		obj.urlLimit = parseInt(obj.inputUrls.length);
		for(i in obj.inputUrls){

			//console.log(obj.inputUrls[i]);
			//obj.whichUrl = parseInt(i)+1;
			download2(obj.inputUrls[i], obj.getExtData, {'obj':obj, 'url':obj.inputUrls[i]})
			//obj.getExtData(obj.inputUrls[i], this.grabUrls, obj)
		}


	}

	this.getExtData= function(urlContent, obj){

        var whichUrl  = obj.url;
        //console.log(whichUrl);
        obj = obj.obj;
        obj.orderedResponse.push(whichUrl);
		obj.whichUrl = obj.whichUrl +1;
		var whichIndex = obj.whichUrl-1;
		obj.dataContent[whichIndex]= urlContent;
		console.log(obj.whichUrl);
		if(obj.urlLimit ==obj.whichUrl){
			obj.whichUrl=0;
			//console.log('finished getting all data');
			obj.findPatterns();

		}

	}

	this.trainSelf= function(){
		

		//input patterns are save specifically that go to changeFind
		//it should do this across variety of ticks (depth)
		//1 then 1, 5 then 5, 10 then 10, 20 then 20, 40 and so (up to 60% of length of input are)

		//check to se if each input arr has same lenght as benchmrk so data is correlated sccurately


			download2(this.benchmark, this.processBenchMark, this );

			//for(j in dataSeries){
				//go first, thens second, then third and go out 1 idstance, 2, all the way to end and find where the change happens

				//go out over up a bit and see how long it coninued uninterupted rise.. maybe

				//look at the other simultaneous conditions

				//save those for training data is good indicators





				//save the i as whichIndex of inputs, along with the distance from forwaed chane to changeFind

				//later we will find the average

				//we will save the pattern as training data to identify with .8 to 1 based on magnitude it is over

				//percent traing change between eac data will be saved

				//}
		
	}




        this.outwayCorr=function(series11, series22, tries, start, end){

            var series1 = series11;
           var  series2=series22;
             if(typeof tries == "undefined"){
                    var tries = 10;
                }

                if(typeof start == "undefined"){
                    var start = 0;
                }

                if(typeof end == "undefined"){
                    var end = (series1.length); //console.log(end);
                }
              series1= series1.slice(start,end);
                series2= series2.slice(start,end);

                var highestCorr = 0;
                var whichRel = "diff";
                var bestOffset = 1;
            for(t= 1; t<= tries; t++ ){
                var off= parseInt(t);
                var theRes = this.determineCorr(series1, series2,off);
                if(theRes['by'] > highestCorr){
                    highestCorr= theRes['by'];
                    whichRel= theRes['results'];
                    bestOffset = off;

                }
               
            }

             return {"offset":bestOffset, "rel":whichRel, "correlation":highestCorr};
        }

        this.determineCorr= function (series1, series2, offset){

          //  console.log('hmm');
            if(typeof offset == "undefined"){
                    offset = 1;
                }
            //generate an array of when what
            var allCor= [];
            for( k in series1){
               // console.log('going');
                if(typeof series2[k] == "undefined"){
                    break;
                }


                k = parseInt(k);
                var n = k+offset;

                if(typeof series1[n] == "undefined"){
                    break;
                }
                var before1= series1[k];
                var after1 = series1[n];

                 var before2= series2[k];
                var after2 = series2[n];

                var toAdd = whenWhat(before1, after1, before2, after2);
                allCor.push(toAdd);


            }
           var result1 = this.getCorrelation(allCor);
            return result1;
        }

       this.whenWhat= function( beforeF1, afterF1, beforeF2, afterF2){

            var whatHappend1 = "lost";
            var whatHappend2 = "lost";
            //
            if(beforeF1 >= afterF1){
                 whatHappend1 = "won";
                //factor 1 increased or stayed same
            }
            else{
                //factor 1 decreased
                 whatHappend1 = "lost";
            }

             if(beforeF2 >= afterF2){
                 whatHappend2 = "won";
                //factor 2 increased or stayed same
            }
            else{
                 whatHappend2 = "lost";
                //factor 1 decreased
            }

            return [whatHappend1, whatHappend2];

        }

        //66 percent correlation
      //  [['won', 'won'],['won', 'won'],['won', 'lost']]

     this.getCorrelation= function(arr1){
            var results = [];
            for(i in arr1){

                if(arr1[i][0] == arr1[i][1]){
                    results.push("same");
                }
                else{

                      results.push("diff");
                }
            }
            var sameNum=0;
            var diffNum = 0;
            var all = results.length;

            for( j in results){
                if(results[j]=="same"){
                    sameNum= sameNum +1;
                }
                else{
                    diffNum = diffNum+1;
                }
            }

            if(diffNum>= sameNum){
                return {results:"diff", "by":(diffNum/all)}
            }

            else{
                return {results:"same", "by":(sameNum/all)}
            }
        }
	


	}


