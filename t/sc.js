window.addEventListener('load', function(e) {
	const textCh = document.querySelectorAll('.textch') || undefined;
	let arr = [];
	
	if (typeof textCh !== 'undefined') {
		textCh.forEach((textChItem) => {
			const ID = textChItem.id;
			const VAL = textChItem.value;
			arr.push(ID + '=' + VAL);
			textChItem.addEventListener('change', function(e) {
			
				
				//const img = document.getElementById('img') || undefined;
				
				console.log(arr.join('&'));
			});
		});
	}
});