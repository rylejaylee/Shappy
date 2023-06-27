<!-- Footer -->
<footer class="text-center text-lg-start bg-light text-muted mt-5 pt-5">
    <!-- Section: Social media -->
    <section class="d-flex justify-content-center justify-content-lg-between p-4 border-bottom">
        <!-- Left -->
        <div class="me-5 d-none d-lg-block">
            <span>Get connected with us on social networks:</span>
        </div>
        <!-- Left -->

        <!-- Right -->
        <div>
            <a href="" class="me-4 text-reset">
                <i class="fab fa-facebook-f"></i>
            </a>
            <a href="" class="me-4 text-reset">
                <i class="fab fa-twitter"></i>
            </a>
            <a href="" class="me-4 text-reset">
                <i class="fab fa-google"></i>
            </a>
            <a href="" class="me-4 text-reset">
                <i class="fab fa-instagram"></i>
            </a>
            <a href="" class="me-4 text-reset">
                <i class="fab fa-linkedin"></i>
            </a>
            <a href="" class="me-4 text-reset">
                <i class="fab fa-github"></i>
            </a>
        </div>
        <!-- Right -->
    </section>
    <!-- Section: Social media -->

    <!-- Section: Links  -->
    <section class="">

    </section>
    <!-- Section: Links  -->

    <!-- Copyright -->
    <div class="text-center p-4" style="background-color: rgba(0, 0, 0, 0.05);">
        © <?php echo date('Y') ?> Copyright:
        <a class="text-reset fw-bold" href="<?php echo url() ?>">sHappy Novels</a>
    </div>
    <!-- Copyright -->
</footer>
<!-- Footer -->


</div>

</body>
<script src="<?php echo asset('js/jquery3.7.0.min.js') ?>"></script>
<script src="<?php echo asset('js/mdb.min.js') ?>"></script>
<script src="https://cdn.tiny.cloud/1/86irwlhi7fad87kyfpkxuz7e4za1urytk0l914dzsjptao3i/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

<script>
    $(document).ready(function() {

        const searchBox = $('#search');
        const dropdownList = $('.dropdown-list');

        searchBox.focus(function() {
            dropdownList.show();
        })

        $(document).on('click', function(event) {
            const targetElement = $(event.target);

            if (!searchBox.is(targetElement) && !dropdownList.is(targetElement) && dropdownList.has(targetElement).length === 0) {
                dropdownList.hide();
            }
        });


        function debounce(func, delay) {
            let timeoutId;
            return function() {
                clearTimeout(timeoutId);
                timeoutId = setTimeout(func, delay);
            }
        }

        function search() {
            dropdownList.show();
            let = searchText = searchBox.val();
            let html = '';
            if (searchText.length < 2) {
                return;
            };

            $.post("<?php echo url('novels/search') ?>", {
                text: searchText
            }, response => {
                let novels = JSON.parse(response);

                if (!novels.length) {
                    html += `
                        <li class="text-center">
                            <div class="card mb-2 shadow-none bg-light">
                                <div class="card-body">
                                      No Results Found.
                                </div>
                            </div>
                        </li>
                        `
                } else {
                    novels.forEach(novel => {
                        html += `
                        <li class="">
                            <a href="<?php echo url('novel/fetch?novel=') ?>${novel['slug']}">
                            <div class="card mb-2 shadow-none bg-light">
                                <div class="card-body" style="padding:8px;">
                                    <div class="d-flex">
                                        <img class="me-2" src="<?php echo img() ?>${novel['img'] ?? 'novel_cover_default.png'}" alt="Novel Image" style="height:75PX; width: 55px">
                                        <div class="d-flex flex-column w-75">
                                            <span class="fw-bold">${novel['title']}</span>
                                            <small class="text-primary">${novel['status']}</small>
                                        </div> 
                                    </div>
                                </div>
                            </div>
                            </a>
                        </li>
                        `
                    });
                }
           
                dropdownList.html(html)
            })
        }

        searchBox.on('input', debounce(search, 500))


    })
</script>

</html>