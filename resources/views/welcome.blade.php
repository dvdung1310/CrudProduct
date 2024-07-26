<!DOCTYPE html>
<html lang="en">

<head>
    <title>CRUD PRODUCT</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <div class="container mt-3">
        <h2 class="text-center">Danh sách các sản phẩm</h2>
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <div class="d-flex align-items-center justify-content-between mb-4">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProductModal">
                Thêm Sản Phẩm
            </button>
            <div class="d-flex">
                <form class="d-flex align-items-center search-container" action="{{ route('search.product') }}">
                    <input class="form-control me-2" type="text" name="product_name" id=""
                        placeholder="Tìm kiếm sản phẩm">
                    <button class="btn btn-info">Tìm kiếm</button>
                </form>
            </div>
        </div>
        <div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addProductModalLabel">Thêm Sản Phẩm</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="form_file_add" action="{{ route('store.product') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="name" class="form-label">Tên Sản Phẩm</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Mô Tả</label>
                                <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="price" class="form-label">Giá</label>
                                <input type="number" class="form-control" id="price" name="price" required>
                            </div>
                            <div class="mb-3">
                                <label for="images" class="form-label">Hình Ảnh</label>
                                <input type="file" class="form-control" id="fileInput" name="images" required>
                            </div>

                            <div>
                                <label for="images" class="form-label">Loại Sản Phẩm</label>
                                <select class="form-control" name="category_id">
                                    @foreach ($category as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                            <button type="submit" class="btn btn-primary">Thêm</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Tên</th>
                    <th>Hình ảnh</th>
                    <th>Thông tin</th>
                    <th>Giá</th>
                    <th>Loại</th>
                    <th>Chức năng</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($listProduct as $key => $item)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $item->product_name }}</td>
                        <td><img style="height: 50px" src="{{ asset($item->images) }}" alt=""></td>
                        <td>{!! $item->description !!}</td>
                        <td class="sumMoney">{{ $item->price }}</td>
                        <td>{{ $item->category_name }}</td>
                        <td>
                            <button type="button" data-bs-toggle="modal"
                                data-bs-target="#updateProductModal{{ $key }}"
                                class="btn btn-primary btn-sm">Sửa</button>
                            <button type="button" data-bs-toggle="modal"
                                data-bs-target="#deleteProductModal{{ $key }}"
                                class="btn btn-danger btn-sm">Xóa</button>
                        </td>
                    </tr>

                    {{-- update --}}
                    <div class="modal fade" id="updateProductModal{{ $key }}" tabindex="-1"
                        aria-labelledby="updateProductModal{{ $key }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addProductModalLabel">Sửa sản phẩm <span
                                            class="text-danger">{{ $item->product_name }}</span></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form id="form_update" action="{{ route('update.product') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $item->product_id }}">
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Tên Sản Phẩm</label>
                                            <input type="text" class="form-control" id="name"
                                                value="{{ $item->product_name }}" name="name" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="description" class="form-label">Mô Tả</label>
                                            <textarea class="form-control description_update" id="description_update_{{ $item->product_id }}" name="description"
                                                rows="3">
                                    {{ $item->description }}
                                </textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label for="price" class="form-label">Giá</label>
                                            <input type="number" class="form-control" value="{{ $item->price }}"
                                                id="price_update" name="price" step="0.01" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="images" class="form-label">Hình Ảnh</label>
                                            <input type="file" class="form-control" id="inputFileUpdate"
                                                name="images">
                                            <img style="height: 88px" src="{{ asset($item->images) }}"
                                                alt="">
                                        </div>

                                        <div>
                                            <label for="images" class="form-label">Loại Sản Phẩm</label>
                                            <select class="form-control" name="category_id">
                                                @foreach ($category as $cateItem)
                                                    <option @if ($item->category_id == $cateItem->id) selected @endif
                                                        value="{{ $cateItem->id }}">{{ $cateItem->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Đóng</button>
                                        <button type="submit" class="btn btn-primary">Sửa</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    {{-- delete --}}
                    <div class="modal fade" id="deleteProductModal{{ $key }}" tabindex="-1"
                        aria-labelledby="updateProductModal{{ $key }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addProductModalLabel">Bạn có chắc chắn xóa sản phẩm
                                        <span class="text-danger">{{ $item->name }}</span>
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Đóng</button>
                                    <a href="{{ route('destroy.product', ['productId' => $item->product_id]) }}"
                                        class="btn btn-primary">Xóa</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-end">
            {{ $listProduct->appends(['product_name' => request('product_name')])->links('pagination::bootstrap-5') }}
        </div>
    </div>


</body>

<script src="https://cdn.ckeditor.com/ckeditor5/34.2.0/classic/ckeditor.js"></script>

<script>
    document.getElementById('form_file_add').addEventListener('submit', function(event) {
        var fileInput = document.getElementById('fileInput');
        var file = fileInput.files[0];
        var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;
        if (!allowedExtensions.exec(file.name)) {
            alert('Chỉ được phép tải lên các file ảnh có định dạng: .jpg, .jpeg, .png, .gif');
            event.preventDefault();
        }

        var price = document.getElementById('price').value;
        if (price <= 0) {
            alert('Gía tiền sản phầm phải > 0 ');
            event.preventDefault();
        }
    });
</script>

<script>
    document.getElementById('form_update').addEventListener('submit', function(event) {
        var fileInput = document.getElementById('inputFileUpdate');
        var file = fileInput.files[0];
        var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;
        if (!allowedExtensions.exec(file.name)) {
            alert('Chỉ được phép tải lên các file ảnh có định dạng: .jpg, .jpeg, .png, .gif');
            event.preventDefault();
        }

        var price = document.getElementById('price_update').value;
        if (price <= 0) {
            alert('Gía tiền sản phầm phải > 0 ');
            event.preventDefault();
        }
    });
</script>


<script>
    ClassicEditor
        .create(document.querySelector('#description'), {
            ckfinder: {
                uploadUrl: "{{ route('store_ckeditor_images', ['_token' => csrf_token()]) }}"
            }
        })
        .catch(error => {
            console.error(error);
        });

    const descriptionElements = document.querySelectorAll('.description_update');
    descriptionElements.forEach((element) => {
        ClassicEditor
            .create(element, {
                ckfinder: {
                    uploadUrl: "{{ route('store_ckeditor_images', ['_token' => csrf_token()]) }}"
                }
            })
            .catch(error => {
                console.error('Có lỗi xảy ra khi khởi tạo CKEditor:', error);
            });
    });
</script>

<script>
    function formatNumber(num) {
        return num.toLocaleString('en-US');
    }
    const sumMoneyElements = document.querySelectorAll('.sumMoney');
    sumMoneyElements.forEach(element => {
        const sumMoneyValue = parseInt(element.textContent, 10);
        element.textContent = formatNumber(sumMoneyValue);
    });
</script>

</html>
