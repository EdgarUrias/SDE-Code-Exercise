var formData = document.getElementById('form');
document.getElementById('sendForm').addEventListener('click', function(){
    axios.post('/calculateSS', new FormData(formData))
    .then(function (response) {
        if(response['data']['status'] == 'error'){
            Swal.fire({
                text: response['data']['message'],
                icon: "error",
                buttonsStyling: false,
                confirmButtonText: "Continuar",
                customClass: {
                    confirmButton: "btn btn-primary"
                }
            })
        }else{
            //console.log(response.data.totalSS)
            document.getElementById('ss').textContent = response.data.totalSS
            document.getElementById('response').style = '';
            // Loop to remove all rows


            var table = document.getElementById('table');

            while (table.firstChild) {
                table.removeChild(table.firstChild);
            }

            for ( var address in response.data.shipmentAssignments) {

                    //shipmentAssignments.hasOwnProperty(address)
                    // Create a new row
                    const newRow = table.insertRow();

                    // Create two cells for the row
                    const cell1 = newRow.insertCell();
                    const cell2 = newRow.insertCell();

                    // Set the content of the cells
                    cell1.textContent = address;
                    cell2.textContent = response.data.shipmentAssignments[address];

              }

        }
    })
    .catch(function (error) {
        Swal.fire({
            text: 'Something went wrong, try again',
            icon: "error",
            buttonsStyling: false,
            confirmButtonText: "Continuar",
            customClass: {
                confirmButton: "btn btn-primary"
            }
        })
    });
});

