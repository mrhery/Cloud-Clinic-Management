function updateClock() {
	var now = new Date();
	
	var day = now.getDate().toString().padStart(2, '0'); 
	var month = now.toLocaleString('default', { month: 'short' }); 
	var year = now.getFullYear();
	var hours = now.getHours().toString().padStart(2, '0');
	var minutes = now.getMinutes().toString().padStart(2, '0');
	var seconds = now.getSeconds().toString().padStart(2, '0'); 

	var formattedTime = `${day} ${month} ${year} ${hours}:${minutes}:${seconds}`;

	$('#clock').text(formattedTime);
}

setInterval(updateClock, 1000);

updateClock();