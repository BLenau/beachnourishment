/** 
 * The url of the master spreadsheet on Google docs used for getting data for
 * the website.
 */

function createDownloadUrl(state) {
    return "https://spreadsheets.google.com/feeds/download/spreadsheets/Export?key=" 
           + stateKeys[state] + "&exportFormat=xls";
}

function createDataUrl(state) {
    return "https://docs.google.com/spreadsheet/tq?key=" + stateKeys[state];
}

var stateKeys = {
    "Master" : "0Ai5L0L8AX-QAdExmRmNrY203UXZWVndzNlg4aFBILUE",
    //"Master" : "0Ai5L0L8AX-QAdEZaZkMxaGp6TmQwMERVS19VbHN5TlE",
    "AL"     : "0AhjSdt3q-XOzdG1Yc3ljSF9zOGZuWlZPOXRpejNxQVE",
    "CA"     : "0AhjSdt3q-XOzdC1UeE1Wb3hTSjI0bVdZV1NjNDVseWc",
    "CT"     : "0AhjSdt3q-XOzdDg4TEcxaDdaelVQdDBQaUxHZkF1d2c",
    "DE"     : "0AhjSdt3q-XOzdEVDNHRRZUpPMU1KODNSSkJBNGlXZkE",
    "FL"     : "0AhjSdt3q-XOzdFBEaHFHMjl0ejc1SzhWQjJqUDkxQ2c",
    "GA"     : "0AhjSdt3q-XOzdDNWd0hZampDempQcUx0YmQwR1ppS3c",
    "LA"     : "0AhjSdt3q-XOzdG5ydEhuNUFyVjh0QXMtaHptSTB1ZEE",
    "MA"     : "0AhjSdt3q-XOzdDBtbTlPVVlSaE1CdkFKaDRvaVpoQlE",
    "MD"     : "0AhjSdt3q-XOzdGdnYTlJdmZ4SF9KenU5QWhiRnlfeWc",
    "ME"     : "0AhjSdt3q-XOzdEtBTVhWUzVnTFBaVy1HeWU4c0haQWc",
    "MS"     : "0AhjSdt3q-XOzdDlCbkhadENQZ0JtSVFnVFVrZGllMkE",
    "NC"     : "0AhjSdt3q-XOzdGlfUDNXOEI3Wi00LTdMZzZVbzUzS3c",
    "NJ"     : "0AhjSdt3q-XOzdFBZUFVjUWllQ0RIZlkwOWxQaXYtZEE",
    "NY"     : "0AhjSdt3q-XOzdHRqWmJ5RHpaZVBrUl9tUkJ2ekhDUFE",
    "RI"     : "0AhjSdt3q-XOzdEQwTHVEVEVua1lXOWIySl9QNmt4SVE",
    "SC"     : "0AhjSdt3q-XOzdEtCaVZ5UDJqN0hXTXc4MVRERlZvRWc",
    "TX"     : "0AhjSdt3q-XOzdHJOWUM5VWZzajhYZ3lHOHZ6NlgzblE",
    "VA"     : "0AhjSdt3q-XOzdE51bEJsV1dlM184QWFJbkdYZUM4b2c",
    "WA"     : "0AhjSdt3q-XOzdHVxakVjTmt4U3JmQlBHb2FMN01NcVE"
};
