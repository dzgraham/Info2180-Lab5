document.addEventListener('DOMContentLoaded', function() {
    const lookupBtn = document.getElementById('lookup');
    const country_search = document.getElementById('country');
    const resultDiv = document.getElementById('result');
    
    lookupBtn.addEventListener('click', function(event) {
        event.preventDefault(); 
        
        const country = country_search.value.trim();
        const XmlHR = new XMLHttpRequest();
        
        let url = 'world.php';
        if (country) {
            url += '?country=' + encodeURIComponent(country);
        }

        XmlHR.open('GET', url, true);
        XmlHR.onload = function() {
            if (XmlHR.status >= 200 && XmlHR.status < 400) {
                resultDiv.innerHTML = XmlHR.responseText;
            } else {
                resultDiv.innerHTML = '<p>Something went wrong.</p>';
            }
        };
        
        XmlHR.onerror = function() {
            resultDiv.innerHTML = '<p>Something went wrong.</p>';
        };
        
        XmlHR.send();
    });
});