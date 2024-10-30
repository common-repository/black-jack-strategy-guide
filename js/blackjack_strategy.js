jQuery(document).ready(function(){
 jQuery('#blackjack-btn').click(function(event){
   event.preventDefault();

   var dealer = jQuery("#blackjack-dealer" ).val();
   var player = jQuery("#blackjack-player" ).val();

if (dealer == null || player == null) {
  jQuery('#blackjack-response').html('<span class="red-alert">No hand values selected!</span>');
} else {
   dealer = parseInt(dealer);
   // player = parseInt(player);  commented this out as the attribs on the rules object are string keyed.

   var decision = {hit : 'Hit', doublehit : 'Double if possible, else hit.', stay : 'Stand', doublestand : 'Double if possible, else stand', split : 'Split', splitdouble : 'Split if double after split is allowed, else hit', surrender : 'Surrender if allowed, else hit'}

   function rng(a, b){
       var A= [a]; while(a+1<= b+1){ A[A.length]= a++; }
       return A;
   }

   var other = rng(1,11)

   var rules = {
       "9": [ [ rng(3,6),   "doublehit"  ]],
      "10": [ [ rng(2,9),   "doublehit" ]],
      "11": [ [ rng(2,10),  "doublehit" ]],
      "12": [ [ rng(4,6),   "stay" ]],
      "13": [ [ rng(2,6),   "stay" ]],
      "14": [ [ rng(2,6),   "stay" ]],
      "15": [ [ [ 10 ],     "surrender" ],  [ rng(2,6), "stay"]],
      "16": [ [ rng(2,6),   "stay"],         [ rng(9,11),"surrender"] ],
      "17": [ [ other,      "stay"] ],
     "1113":[ [ [5,6],      "doublehit"]],
     "1114":[ [ [5,6],      "doublehit"]],
     "1115":[ [ [4,5,6],    "doublehit"]],
     "1116":[ [ [4,5,6],    "doublehit"]],      
     "1117":[ [ [4,5,6],    "doublehit"]],      
     "1118":[ [ [3,4,5,6],  "doublehit"],  [ [2,7,8],  "stay"] ],
     "1119":[ [ other,    "stay"]],
      "22": [ [ [2,3],      "splitdouble"], [ rng(4,7), "split" ] ],
       "33":[ [ [2,3],      "splitdouble"], [ rng(4,7), "split" ] ],
       "44":[ [ [5,6],      "splitdouble"]],
       "66":[ [ [2],    "splitdouble"], [ rng(3,6), "split"]],
       "77":[ [ [ rng(2,7) ],    "split"]],      
       "88":[ [ other,    "split"] ],      
       "99":[ [ [7,10,11],  "stay"],  [ other, "split"]],
       "1111":[ [ other,    "split"]]              
   }

   var answer = "Hit" // default answer, default switch part

   var rule = rules[player];

    for (var i = 0; i < rule.length; i++) {
     if (~rule[i][0].indexOf(dealer)) {
       answer = decision[rule[i][1]];
       /*
       If wish to log to console
       console.log("chose answer " + answer + " for player [" + player + "] and dealer [" + dealer + "]")
       */
       break;
     }
     }

   jQuery('#blackjack-response').html(answer);
 } // Big else closes
 }); 
});