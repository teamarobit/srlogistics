

// 
    document.getElementById("driverSelect").addEventListener("change", function() {
        let value = this.value;
        if (value) {
            // Split value into name, number, image
            let [name, number, img] = value.split("|");

            // Fill inputs
            document.getElementById("driverName").value = name;
            document.getElementById("driverNumber").value = number;
            document.getElementById("driverImage").innerHTML = `<img src="${img}" width="80" alt="Driver">`;
        } else {
            // Reset if no selection
            document.getElementById("driverName").value = "";
            document.getElementById("driverNumber").value = "";
            document.getElementById("driverImage").innerHTML = `<img src="images/user.png" width="80" alt="Driver">`;
        }
    });
// 