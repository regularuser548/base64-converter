<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Image to Base64 Converter</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col d-flex justify-content-center flex-wrap">

                    <template id="resultItemTemplate">
                        <div class="resultItem d-flex justify-content-between m-1 p-2 bg-success text-dark bg-opacity-25 border border-secondary rounded">
                            <span class="fileName fw-bold w-25 ms-2 me-2 text-break"></span>
                            <span class="fileSize ms-2 me-2"></span>
                            <span class="status ms-2 me-2"></span>
                            <span class="convertedFileSize ms-2 me-2"></span>
                            <button class="copyToClipBtn btn btn-secondary btn-sm">Copy</button>
                        </div>
                    </template>

                    <template id="errorItemTemplate">
                        <div class="errorItem d-flex justify-content-between m-1 p-2 bg-danger text-dark bg-opacity-25 border border-secondary rounded">
                            <span class="fileName fw-bold w-25 ms-2 me-2 text-break"></span>
                            <span class="fileSize ms-2 me-2"></span>
                            <span class="status ms-2 me-2"></span>
                            <span class="message text-wrap"></span>
                        </div>
                    </template>


                    <div class="mb-4">
                        <h2>Convert your images to base64</h2>

                        <div id="messageContainer">

                        </div>

                        <form class="d-flex">
                            @csrf
                            <input onchange="sendAjaxRequests()" id="pictures" name="pictures" type="file" required multiple accept="image/*" class="form-control">
                        </form>
                    </div>

                </div>
            </div>

            <div class="row">
                <div class="col">
                    <div id="resultsContainer">

                    </div>
                </div>
            </div>

        </div>
    <script>

        let picturesArray = [];

        function sendAjaxRequests()
        {
            let picturesArray = document.getElementById('pictures').files;

            let csrf = document.getElementsByName('_token')[0].value;

            if (picturesArray.length > 10)
            {
                setMessage('You can upload up to 10 files at once');
                return;
            }

            for (let i = 0; i < picturesArray.length; i++)
            {
                const formData = new FormData();
                formData.append("picture", picturesArray[i]);
                formData.append('_token', csrf);
                fetch("{{route('encodeImageAjax')}}",{
                    method: "POST",
                    body: formData,
                    headers: {
                        "Accept": "application/json",
                    },
                }).then(imageEncodingCallback, errorCallback);
            }
        }

        function errorCallback()
        {
            setMessage("Server is not responding");
        }

        async function imageEncodingCallback(response)
        {
            let res = await response.json();
            const container = document.getElementById('resultsContainer');

            let template;
            if (res['errors']) //error
                template = document.getElementById('errorItemTemplate');

            else //success
                template = document.getElementById('resultItemTemplate');

            const clone = template.content.cloneNode(true);

            clone.querySelector('.fileName').textContent = res.fileName;
            clone.querySelector('.fileSize').textContent = res.fileSizeBytes / 1000 + ' KB';

            if (res['errors'])
            {
                clone.querySelector('.status').textContent = 'Error';
                clone.querySelector('.message').textContent = res.errors.picture[0];
            }
            else
            {
                let length = picturesArray.push(res);
                clone.querySelector('.status').textContent = 'Success';
                clone.querySelector('.convertedFileSize').textContent = res.encodedFileSizeBytes / 1000 + ' KB';
                clone.querySelector('.copyToClipBtn').onclick = async function() { await copyToClipboard(length - 1); };
            }

            container.appendChild(clone);

            //console.log(picturesArray);
        }

        async function copyToClipboard(id)
        {
            await navigator.clipboard.writeText(picturesArray[id].base64);
        }

        function setMessage(text)
        {
            const container = document.getElementById('messageContainer');
            let toDelete = container.getElementsByClassName('alert');

            if (toDelete.length > 0)
                toDelete[0].remove();

            const messageText = text;
            const message = document.createElement('div');
            message.className = 'alert alert-danger alert-dismissible fade show';
            message.innerHTML = `${messageText}<button type="button" class="btn-close" data-bs-dismiss="alert"></button>`;
            container.appendChild(message);
        }

    </script>
    </body>
</html>
