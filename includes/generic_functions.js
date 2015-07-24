module.exports = {
    parseURL: parseURL,
	encloseQuotes: encloseQuotes
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