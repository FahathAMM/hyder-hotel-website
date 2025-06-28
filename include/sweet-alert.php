<script src="https://unpkg.com/@dotlottie/player-component@2.7.12/dist/dotlottie-player.mjs" type="module"></script>
<script src="https://unpkg.com/@lottiefiles/dotlottie-wc@0.3.0/dist/dotlottie-wc.js" type="module"></script>

<script>
    function htmlTemp(title, message, api, iconUrl, iconUrl1 = null) {
        return `
    <div class="mt-3">
        <div class="avatar-lg mx-auto" style="height:7rem;width:18rem">
            <div class="text-success display-5 rounded-circle">
                <dotlottie-player
                    src="${iconUrl}"
                    speed="1"
                    background="transparent"
                    loop
                    autoplay
                    style="width: 300px; height: 150px;">
                </dotlottie-player>

                <h6 class="text-center text-success" id="timer" style="margin-top: -28px;">0 sec</h6>

                <dotlottie-wc
                    src="${iconUrl1}"
                    speed="1"
                    background="transparent"
                    loop
                    autoplay
                    type="module"
                    style="width: 300px;height: 15px;margin: -10px 0 0px 0px;">
                </dotlottie-wc>
            </div>
        </div>
        <div class="mt-4 pt-2 fs-15 text-center">
            <h4 class="fs-20 fw-semibold">${title}</h4>
            <p class="text-muted mb-0 mt-3 fs-13">
                ${message}
                <br/>
                <span class="fw-medium text-dark">${api}</span>
            </p>
        </div>
    </div>`;
    }


    // function htmlTemp(title, message, api, iconUrl) {
    //     return `
    //     <div class="mt-3">
    //         <div class="avatar-lg mx-auto">
    //             <div class="text-success display-5 rounded-circle">
    //                 <lord-icon
    //                     src="${iconUrl}"
    //                     trigger="loop"
    //                     style="width: 120px; height: 120px;">
    //                 </lord-icon>
    //             </div>
    //         </div>
    //         <div class="mt-4 pt-2 fs-15 text-center">
    //             <h4 class="fs-20 fw-semibold">${title}</h4>
    //             <p class="text-muted mb-0 mt-3 fs-13">
    //                 ${message}
    //                 <br/>
    //                 <span class="fw-medium text-dark">${api}</span>
    //             </p>
    //         </div>
    //     </div>`;
    // }

    function showSwalSuccess(
        title = "Fetching data, please wait...",
        message = "Hang on, we’re gathering everything you need from the server",
        api = "",
        iconUrl = "https://lottie.host/5804115b-85d9-469f-8d16-145de736d073/cXAWJiWfbE.lottie",
        iconUrl1 = "https://lottie.host/6edbd009-e97c-4992-b01e-02e0c421b775/UgV0LCNVXu.lottie",
        isClose = false
    ) {
        let html = htmlTemp(title, message, api, iconUrl, iconUrl1);

        Swal.fire({
            html: html,
            // confirmButtonClass: "btn btn-primary mb-1",
            buttonsStyling: false,
            showCloseButton: isClose,
            showConfirmButton: 0,
            allowOutsideClick: isClose, // disables closing by clicking outside
            allowEscapeKey: isClose, // disables closing by pressing ESC
        });
    }

    function closeSwal(time = null) {
        if (!time) {
            Swal.close();
            return;
        } else {
            setTimeout(() => {
                Swal.close();
            }, time);
        }
    }

    let seconds = 0;
    let timerInterval = null;

    function startTimer(isAlive = true) {
        if (!isAlive) {
            clearInterval(timerInterval);
            timerInterval = false;
            return;
        }
        clearInterval(timerInterval); // Ensure no duplicate intervals
        seconds = 0;
        const timerElement = document.getElementById("timer");

        // if (timerElement) {
        //     timerInterval = setInterval(() => {
        //         seconds++;
        //         timerElement.innerText = `${seconds} sec`;
        //     }, 1000);
        // }

        // if (timerElement) {
        //     timerInterval = setInterval(() => {
        //         seconds++;

        //         if (seconds < 60) {
        //             timerElement.innerText = `${seconds} sec`;
        //         } else {
        //             const mins = Math.floor(seconds / 60);
        //             timerElement.innerText = `${mins} min (${seconds} sec)`;
        //         }
        //     }, 1000);
        // }

        if (timerElement) {
            timerInterval = setInterval(() => {
                seconds++;

                if (seconds < 60) {
                    timerElement.innerText = `${seconds} sec`;
                } else {
                    const mins = Math.floor(seconds / 60);
                    const remSecs = seconds % 60;
                    timerElement.innerText = `${mins} min ${remSecs} sec`;
                }
            }, 1000);
        }
    }

    function stopTimer() {
        clearInterval(timerInterval);
        timerInterval = false;
    }
</script>