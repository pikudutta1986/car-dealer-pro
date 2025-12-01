// SCRIPT FOR FETCH DATA BY VIN AND YEAR STARTS.
disableSaveButton();
var makeArray = [];

// Check for input values on keyup event for both fields
document.getElementById('vin').addEventListener('keyup', handleInput);
document.getElementById('year').addEventListener('change', handleInput);

function handleInput() {
    var year = document.getElementById('year').value;
    var vin = document.getElementById('vin').value;

    if (year != '' && vin != '') {
        enableFetchButton();
    }
}

function getInputValue(event) {
    event.preventDefault();
    var yearInput = document.getElementById('year');
    var year = yearInput.value;

    var vinInput = document.getElementById('vin');
    var vin = vinInput.value;

    if (year != '' && vin != '') {
        getVInData(vin, year);
    }
}

function getVinData(vin, year) {
    var showInstructionMessage = document.getElementById('showInstructionMessage');

    var url = 'https://vpic.nhtsa.dot.gov/api/vehicles/decodevinextended/' + vin + '?format=json&modelyear=' + year + '';
    $.ajax({
        url: (url),
        type: 'GET',
        dataType: 'json',
        success: function(res) {
            if (res.Count > 0) {
                console.log("res>>>>>", res);

                let resMakeObj = res.Results.find((x) => x.Variable == 'Make');

                if (resMakeObj) {
                    let resMake = resMakeObj.Value;

                    if (resMake) {
                        let makeObj = makeArray.find((x) => resMake.toLowerCase().indexOf(x.make.toLowerCase()) !== -1);
                        console.log(makeObj, "make obj");
                        if (makeObj) {
                            //vinInput.setAttribute('readonly', true);
                            enableSaveButton();

                            showInstructionMessage.style.display = 'none';

                            // removeDisableAttr();

                            $("#car_make").val(makeObj.make_slug);
                            var resModelObj = res.Results.find((y) => y.Variable == 'Model');
                            var modelSlug = slugify(resModelObj?.Value);
                            ChangeMake(makeObj.make_slug, "car_model", modelSlug);

                        } else {
                            disableSaveButton();
                            console.log('not make obj');
                            showInstructionMessage.innerHTML = 'Please insert valid vin or year.';
                            showInstructionMessage.style.color = 'red';

                        }
                    }
                }

                setTimeout(() => {
                    getAllFieldSelected(res.Results)
                }, 200);

            }
        }
    });
}

function getAllFieldSelected(results) {
    console.log("results", results);

    // Set Number of cylinders........
    let resCylindersObj = results.find((a) => a.Variable == 'Engine Number of Cylinders');

    if (resCylindersObj) {
        let resCylinder = resCylindersObj.Value;
        $("#engine").val(resCylinder);
    }

    // Set Doors ............
    let resDoorsObj = results.find((c) => c.Variable == 'Doors');

    if (resDoorsObj) {
        let resDoor = resDoorsObj.Value;
        $("#doors").val(resDoor);
    }

    // Set fuel type..........
    let resFuelObj = results.find((e) => e.Variable == 'Fuel Type - Primary');

    if (resFuelObj) {
        let resFuel = resFuelObj.Value;
        $("#fuel_type").val(resFuel);
    }

    // Set Transmission..........
    let resTransObj = results.find((g) => g.Variable == 'Transmission Style');

    if (resTransObj) {
        let resTrans = resTransObj.Value;
        $("#transmission").val(resTrans);
    }

    // Set Vehicle type.........
    let resVehicleTypeObj = results.find((w) => w.Variable == 'Body Class');

    if (resVehicleTypeObj) {
        let resVehicleType = resVehicleTypeObj.Value;
        $("#bodystyle").val(resVehicleType);
    }

    // Set trim Value........... 
    let trimObj = results.find((m) => m.Variable == 'Trim');

    if (trimObj) {
        let trim = trimObj.Value;
        $('#trim').val(trim);
    }

}

function validateVin() {
    var vinElm = document.getElementById('vin');
    var errorMessage = document.getElementById('errorMessage');
    var vin = vinElm.value;
    var isValid = /^[A-Z0-9]+$/.test(vin); // Regex pattern to match capital letters or numbers.

    if (vin == '') {
        errorMessage.style.display = 'none';
    } else {
        if (!isValid) {
            errorMessage.style.display = 'block';

        } else {
            errorMessage.style.display = 'none';
        }
    }
}

function disableFetchButton() {
    var fetchDataButton = document.getElementById('fetchDataButton');
    fetchDataButton.disabled = true;
    fetchDataButton.style.opacity = '0.5';
    fetchDataButton.style.cursor = 'not-allowed';
}

function enableFetchButton() {
    console.log("fetch button");
    var fetchDataButton = document.getElementById('fetchDataButton');
    fetchDataButton.disabled = false;
    fetchDataButton.style.opacity = '1';
    fetchDataButton.style.cursor = 'pointer';
}

function disableSaveButton() {
    var saveButton = document.getElementById('saveButton');
    saveButton.disabled = true;
    saveButton.style.opacity = '0.5';
    saveButton.style.cursor = 'not-allowed';
}

function enableSaveButton() {
    var saveButton = document.getElementById('saveButton');
    saveButton.disabled = false;
    saveButton.style.opacity = '1';
    saveButton.style.cursor = 'pointer';
}