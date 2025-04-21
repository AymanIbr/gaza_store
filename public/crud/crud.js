// Add New Category
// console.log(document.querySelector("#add-new-category form"));
document.querySelector("#add-new-category form").onsubmit = (e) => {
    e.preventDefault();
    let form = document.querySelector("#add-new-category form");
    let url = form.action;

    let data = new FormData(form);

    axios
        .post(url, data)
        .then((res) => {
            // hide modal
            const modalElement = document.getElementById("add-new-category");
            const modal = bootstrap.Modal.getInstance(modalElement);
            modal.hide();

            modalElement.querySelector("form").reset();

            document.querySelector(".table-content").innerHTML = res.data.data;

            const currentCount = parseInt(
                document
                    .querySelector(".count-category")
                    .textContent.match(/\d+/)[0]
            );
            document.querySelector(
                ".count-category"
            ).innerHTML = `All Categories ${currentCount + 1}`;

            Swal.fire({
                title: "Good job!",
                text: res.data.msg,
                icon: "success",
            });
        })
        .catch((err) => {
            if (err.response.status == 422) {
                let error_message = "";
                for (error in err.response.data.errors) {
                    error_message += `<p> ${err.response.data.errors[error][0]} </p>`;
                }
                console.log(error_message);
                document.querySelector(".alert-error").innerHTML =
                    error_message;
                document
                    .querySelector(".alert-error")
                    .classList.remove("d-none");
            }
        });
};

// pagination

document.querySelector(".table-content").onclick = (e) => {
    let link = e.target.closest("a");
    if (link && link.closest("div.pagination")) {
        e.preventDefault();

        let url = link.href;
        axios
            .get(url)
            .then((res) => {
                document.querySelector(".table-content").innerHTML =
                    res.data.data;
            })
            .catch((err) => {
                console.log(err);
            });
    }
    //end pagination
    // console.log(link);

    // Edit category modal

    if (link.classList.contains("edit-row")) {
        e.preventDefault();
        let target = link.dataset.bsTarget;
        let form = document.querySelector(`${target} form`);
        let alertBox = document.querySelector(`${target} .alert-error`);

        let name_en = document.querySelector(`${target} #name_en`);
        let name_ar = document.querySelector(`${target} #name_ar`);
        let description_en = document.querySelector(
            `${target} #description_en`
        );
        let description_ar = document.querySelector(
            `${target} #description_ar`
        );

        let previewImage = document.querySelector(`${target} .prev-img`);
        let url = link.href;

        axios
            .get(url)
            .then((res) => {
                if (res.status == 200) {
                    let data = res.data.data;
                    console.log(data);

                    let name = JSON.parse(data.name);
                    let description = JSON.parse(data.description);

                    name_en.value = name.en;
                    name_ar.value = name.ar;
                    description_en.value = description.en;
                    description_ar.value = description.ar;
                    
                    previewImage.src = res.data.data.image_path;
                    form.action = "categories/" + res.data.data.id;
                }
            })
            .catch((err) => {
                console.log(err);
            });

        form.onsubmit = (e) => {
            e.preventDefault();
            let url = form.action;
            let data = new FormData(form);

            data.append("image", document.querySelector("#image").files[0]);
            axios
                .post(url, data)
                .then((res) => {
                    const modalElement =
                        document.getElementById("edit-category");
                    const modal = bootstrap.Modal.getInstance(modalElement);
                    modal.hide();

                    document.querySelector(".table-content").innerHTML =
                        res.data.data;

                    Swal.fire({
                        title: "Good job!",
                        text: res.data.msg,
                        icon: "success",
                    });
                })
                .catch((err) => {
                    if (err.response && err.response.status == 422) {
                        let error_message = "";
                        for (let error in err.response.data.errors) {
                            error_message += `<p>${err.response.data.errors[error][0]}</p>`;
                        }
                        alertBox.innerHTML = error_message;
                        alertBox.classList.remove("d-none");
                    }
                });
        };
    }
};

// Search
function filter(e) {
    e.preventDefault();
    let searchInput = document.querySelector("[name=search]");
    let orderInput = document.querySelector("[name=order]");
    let countInput = document.querySelector("[name=count]");

    console.log(searchInput, orderInput, countInput);
    let url = window.location.href;
    console.log(url);

    axios
        .get(url, {
            params: {
                search: searchInput.value,
                order: orderInput.value,
                count: countInput.value,
            },
        })
        .then((res) => {
            document.querySelector(".table-content").innerHTML = res.data.data;
        })
        .catch((err) => {
            console.log(err);
        });
}

// Delete

function confirmDestroy(e) {
    e.preventDefault();

    let url = e.target.closest("form").action;
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "question",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
    }).then((result) => {
        if (result.isConfirmed) {
            axios
                .post(url, {
                    _method: "DELETE",
                })
                .then((res) => {
                    document.querySelector(".table-content").innerHTML =
                        res.data.data;

                    const data = res.data;
                    Swal.fire({
                        icon: data.icon,
                        title: data.title,
                        text: data.text,
                        showConfirmButton: false,
                        timer: 1500,
                    });
                })
                .catch((err) => {
                    console.log(err);
                });
        }
    });
}
