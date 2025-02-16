//different datatype (string, number, boolean, null, undefined, object, symbol)


var name = 'ram';
'ram'.toUpperCase();
//output: RAM

'ram'.length;
//output: 3

function add(a, b) {
    return a + b;
}

//global scope (not recommended)
function hi(){
    name = 'ram';
   console.log('hi');
}
 name
//output: 'ram'

//local scope
function hi(){
    var name = 'ram';
    console.log('hi');
} 

name
//output: undefined

//statements
for(i=0; i<10; i++){
       if(i===3){
        break;
       }
    console.log('hi');
}

for(i=0; i<10; i++){
    if(i===3){
    continue;
    }
 console.log('hi');
}


//alert, confirm, prompt
alert('hi');
//output: alert box with 'hi'
function show_alert(){
    alert('hi');
}

<button onclick="show_alert()">click</button>


confirm('hi');
//output: true or false
prompt('hi');
//output: input box with 'hi'

//built-in classes
var date = new Date();
//output: current date and time
var str = new String('ram');
//output: 'ram'
var num = new Number(10);   
//output: 10
Math.random();
//output: random number between 0 and 1
Math.floor(2.5);
//output: 2
Math.ceil(2.5);
//output: 3


document.getElementById('id');
//output: element with id 'id'
document.getElementsByClassName('class');
//output: element with class 'class'
document.getElementsByTagName('tag');
//output: element with tag 'tag'

//forin loop (array)
var cars = [c1, c2, c3];
Car.length
//output: 3

for(var i in car){
    console.log(car[i]);
}
//output: c1, c2, c3

for(car in cars)
{
    console.log(cars[car]);
}
//output: c1, c2, c3

//js is oop
//class and methods
class Car {
    constructor(color) {
        this.color = color;
    }
    drive() {
        console.log('drive');
        }
    }

//condensed array
var arr = [1, 2, 3];
arr[0];
//output: 1


//convetional array
var arr = new Array(1, 2, 3);     
arr[0];
//output: 1


//methods associated with array
bikes.concat[car];
//output: bikes + car

