/*
	Проверка формы index.php на корректость данных
*/

function formValidate ()
{	
	let feedinp = document.getElementById('feedinp');
	let feedtextarea = document.getElementById('feedtextarea');

	if (feedinp.value == '')
	{
		feedinp.style.borderColor = 'red';
		feedtextarea.style.borderColor = '';
		event.preventDefault();
	} else {

		if (feedtextarea.value == '')
		{
			feedtextarea.style.borderColor = 'red';
			feedinp.style.borderColor = '';
			event.preventDefault();
		} else {
			return true;
		}
	}
}