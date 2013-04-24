/**
 * Get the length of a property as defined by the number of propertied that it
 * has.
 *
 * @param  the object you want to find the number of properties of
 * @return the number of properties the object has
 */
function getPropertyLength(object) {
    var i = 0;
    for (var prop in object) {
        if (object.hasOwnProperty(prop)) {
            i++;
        }
    }
    return i;
}

/**
 * Uses regular expressions to format a normal integer into a number with
 * commas in it.
 *
 * @param  x the number you want to add commas to
 * @return the formatted number with commas every three digits.
 */
function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(?:\d{3})+(?!\d))/g, ",");
}

/**
 * Rounds a number to the specified number of decimal places.
 *
 * @param  num the number to round
 * @param  dec the number of decimal places to round to
 * @return the rounded number
 */
function roundNumber(num, dec) {
    var result = Math.round(num * Math.pow(10 ,dec)) / Math.pow(10 ,dec);
    return result;
}

/**
 * Trims the whitespace from the end of a string. This only applies to spaces,
 * not newlines.
 *
 * @param  strText the string to trim the whitespace from
 * @return the trimmed string
 */
function trim(strText) { 
    while (strText.substring(0,1) == ' ') {
       strText = strText.substring(1, strText.length);
    }
    while (strText.substring(strText.length-1,strText.length) == ' ') {
        strText = strText.substring(0, strText.length-1);
    }
    return strText;
} 

/**
 * Determines whether the entered parameter is a number. The parameter can be
 * any legal argument in javascript.
 *
 * @param  n the thing to check if it is a number
 * @return whether the parameter is a number or not
 */
function isNumber(n) {
    return !isNaN(parseFloat(n)) && isFinite(n);
}
