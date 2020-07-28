//array to be sorted
var stringArray = ['ANTONIO', 'ALCIDES', 'WESLEY', '1 ZENAIDA'];

//comparing function

function sorting(a,b) {
    return a - b;
}

//Sorting without comparign function
console.log(stringArray.sort());

//Sorting WITH comparign function
console.log(
    stringArray.sort(sorting)
);

// see ya o//



