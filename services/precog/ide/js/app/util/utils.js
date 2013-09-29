define([],

function() {
   return {
       arrayDiff : function(a1, a2) {
           return a1.filter(function(i) {return !(a2.indexOf(i) > -1);});
       },
       guid : function() {
           var S4 = function() {
               return (((1+Math.random())*0x10000)|0).toString(16).substring(1);
           };
           return (S4()+S4()+"-"+S4()+"-"+S4()+"-"+S4()+"-"+S4()+S4()+S4());
       }
   }
});