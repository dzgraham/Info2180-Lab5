document.addEventListener('DOMContentLoaded', function() {
    const lookupBtn = document.getElementById('lookup');
    const lookupCitiesBtn = document.getElementById('lookupCities');
    const country_search = document.getElementById('country');
    const resultDiv = document.getElementById('result');
    
    function makeRequest(lookupType) {
        const country = country_search.value.trim();
        
        const XmlHR = new XMLHttpRequest();
        let url = 'world.php';
        let query_params = [];
        
        if (country) {
            query_params.push('country=' + encodeURIComponent(country));
        }
        
        if (lookupType === 'cities') {
            query_params.push('lookup=cities');
        }
        
        if (query_params.length > 0) {
            url += '?' + query_params.join('&');
        }
        
        XmlHR.open('GET', url, true);
        
        XmlHR.onload = function() {
            if (XmlHR.status === 200) {
                resultDiv.innerHTML = XmlHR.responseText;
            } else {
                resultDiv.innerHTML = '<p>Something went wrong.</p>';
            }
        };
        
        XmlHR.send();
    }
    
    lookupBtn.addEventListener('click', function() {
        makeRequest('countries');
    });
    
    lookupCitiesBtn.addEventListener('click', function() {
        makeRequest('cities');
    });
    
   
});