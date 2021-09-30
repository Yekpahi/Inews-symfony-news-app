function myfun() {

    var filesAmount = document.getElementById("myinput").files.length;
    for (var i = 0; i < filesAmount; i++) {
        reader = new FileReader();
        reader.onload = function() {
                if (reader.readyState = "complete") {
                    placeToInsertImagePreview = document.getElementById('showImg')
                    CreateIMGANDapendedImg = $($.parseHTML('<img class="appendedImg">')).attr('src', event.target.result)
                        // IMGsurroundedByDiv = `<div class="imgHolder">` + CreateIMGANDapendedImg + `</div>`;
                    IMGsurroundedByDiv = $($.parseHTML('<div class="imgHolder">')).html(CreateIMGANDapendedImg)
                    IMGsurroundedByDiv.append('<span class="closeIT_removeImg">X</span>')
                    $("#showImg").append(IMGsurroundedByDiv)
                } // readyState
            } // onload 
        setTimeout(function() {
            closeIT_removeImg = document.getElementsByClassName('closeIT_removeImg')
            arrayFormCloseBtn = [...closeIT_removeImg];
            arrayFormCloseBtn.forEach((onebyone) => {
                onebyone.addEventListener('click', function(e) {
                    document.getElementById('showModelB4Del_removeImg').style.display = 'flex';
                    document.addEventListener('click', function(e) {
                        if (e.target.classList[0] == 'closeIT_removeImg') {
                            closeIT_removeImg = e.target;
                            document.getElementById('showModelB4Del_removeImg').style.display = 'flex';
                            showModelB4Del_removeImg.addEventListener('click', function(e) {
                                if (e.target.id == 'yesDelContact') {
                                    closeIT_removeImg.parentElement.classList.add('b4Remove')
                                    closeIT_removeImg.parentElement.addEventListener('transitionend', function() {
                                        closeIT_removeImg.parentElement.remove();
                                    })
                                    document.getElementById('showModelB4Del_removeImg').style.display = 'none';
                                } else if (e.target.id == 'closModalMsg') {
                                    document.getElementById('showModelB4Del_removeImg').style.display = 'none';
                                }
                            })

                        }

                    })

                })
            })

        }, 500)
        reader.readAsDataURL(document.getElementById("myinput").files[i]);
    } 
}