function moneyFormat(amount, decimalCount = 0, decimal = " ", thousands = " ") {
    try {
        decimalCount = Math.abs(decimalCount);
        decimalCount = isNaN(decimalCount) ? 2 : decimalCount;

        const negativeSign = amount < 0 ? "-" : "";

        let i = parseInt(amount = Math.abs(Number(amount) || 0).toFixed(decimalCount)).toString();
        let j = (i.length > 3) ? i.length % 3 : 0;
        let now_currency = typeof(currency) == "undefined" ? 'UZS' : currency;

        return negativeSign + (j ? i.substr(0, j) + thousands : '') + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thousands) + (decimalCount ? decimal + Math.abs(amount - i).toFixed(decimalCount).slice(2) : "") + ' ' + now_currency;
    } catch (e) {
        console.log(e)
    }
}

function moneyRound(amount) {
    try {
        return Math.round(Math.abs(amount) / 500).toFixed(1) * 500;
    } catch (e) {
        console.log(e)
    }
}
