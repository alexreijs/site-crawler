module.exports = {
	parseURL: parseURL,
	encloseQuotes: encloseQuotes,
	shuffle: shuffle
};

function parseURL(url) {
    a =  document.createElement('a');
    a.href = url;
    
	results = {
        source: url,
        protocol: a.protocol.replace(':',''),
        host: a.hostname,
        path: a.pathname,
        port: a.port,
        query: a.search,
        hash: a.hash.replace('#','')
    };
	
	delete a;
	return results;
}


function encloseQuotes(string) {
	return '"' + string + '"';
}


function shuffle(array) {
	var currentIndex = array.length, temporaryValue, randomIndex;

	// While there remain elements to shuffle...
	while (0 !== currentIndex) {

		// Pick a remaining element...
		randomIndex = Math.floor(Math.random() * currentIndex);
		currentIndex -= 1;

		// And swap it with the current element.
		temporaryValue = array[currentIndex];
		array[currentIndex] = array[randomIndex];
		array[randomIndex] = temporaryValue;
	}

	return array;
}
