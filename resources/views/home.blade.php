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
                            <span class="fileName fw-bold w-25"></span>
                            <span class="fileSize"></span>
                            <span class="status"></span>
                            <span class="convertedFileSize"></span>
                            <button class="copyToClipBtn btn btn-secondary btn-sm">Copy</button>
                        </div>
                    </template>

                    <div class="mb-4">
                        <h2>Convert your images to base64</h2>
                        <form class="d-flex" action="{{route('encodeImageAjax')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <input onchange="sendAjaxRequests(event)" id="pictures" type="file" name="pictures" required multiple accept="image/*" class="form-control me-1">
                        </form>
                    </div>

                </div>
            </div>

            <div class="row">
                <div class="col">
                    <div class="ps-5 pe-5" id="resultsContainer">

                    </div>
                </div>
            </div>

        </div>
    <script>

        let picturesArray = [];

        function sendAjaxRequests(event)
        {
            let picturesArray = document.getElementById('pictures').files;

            //do some validation
            for (let i = 0; i < picturesArray.length; i++)
            {
                const formData = new FormData();
                formData.append("picture", picturesArray[i]);
                fetch("{{route('encodeImageAjax')}}",{
                    method: "POST",
                    body: formData
                }).then(ImageEncodingCallback);
            }
        }

        async function ImageEncodingCallback(response)
        {
            let res = await response.json();
            let length = picturesArray.push(res);

            const container = document.getElementById('resultsContainer');
            const template = document.getElementById('resultItemTemplate');

            const clone = template.content.cloneNode(true);

            clone.querySelector('.fileName').textContent = res.fileName;
            clone.querySelector('.fileSize').textContent = '12 kb';
            clone.querySelector('.status').textContent = 'success';
            clone.querySelector('.convertedFileSize').textContent = '15 kb';
            clone.querySelector('.copyToClipBtn').onclick = async function() { await copyToClipboard(length - 1); };

            console.log(clone.querySelector('.copyToClipBtn').onClick);

            container.appendChild(clone);

            console.log(picturesArray);

        }

        async function copyToClipboard(id)
        {
            //alert(id);
            
            await navigator.clipboard.writeText(picturesArray[id].base64);
        }

    </script>
    </body>
</html>
