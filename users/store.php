<?php
require_once("process_store.php");
include("head.php");

if (!isset($_GET['id'])) {
    header("location: index.php");
} else {
    $id = $_GET['id'];
}

$checkStore = $mysqli->query("SELECT * FROM pharmacy_store WHERE id='$id' ");
$store = mysqli_fetch_array($checkStore)
?>
<title>PharmaClique - Pharmacy</title>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php include("sidebar.php"); ?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php include("topbar.php"); ?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <div id="vueApp">

                        <!-- Notification here -->
                        <?php
                        if (isset($_SESSION['pharmacyError'])) { ?>
                            <div class="alert alert-<?php echo $_SESSION['msg_type']; ?> alert-dismissible">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <?php
                                echo $_SESSION['pharmacyError'];
                                unset($_SESSION['pharmacyError']);
                                ?>
                            </div>
                        <?php } ?>
                        <!-- End Notification -->


                        <!-- Notification here -->
                        <div v-if="showNotification" class="alert alert-success alert-dismissible">
                            <a href="#" class="close" aria-label="close" @click="showNotification = false">&times;</a>
                            {{ messageNotification }}
                        </div>
                        <!-- End Notification -->


                        <!-- Page Heading -->
                        <div class="d-sm-flex align-items-center justify-content-between mb-4">
                            <h1 class="h3 mb-0 text-gray-800">Pharmacy - <?php echo $store["store_name"]; ?></h1>
                        </div>



                        
                        <div class="row">
                        <!-- List of Products -->
                        <div class="col-lg-12">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">List of Products</h6>
                                </div>
                                <div class="card-body">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Brand</th>
                                                <th>Product Code</th>
                                                <th>Product Name</th>
                                                <th>Product Description</th>
                                                <th>Price</th>
                                                <th>Stock</th>
                                                <th>Weight</th>
                                                <th>Photo Link</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="p in products">
                                                <td>{{p.id}}</td>
                                                <td>{{p.product_brand}}</td>
                                                <td>{{p.product_code}}</td>
                                                <td>{{p.product_name}}</td>
                                                <td>{{p.product_description}}</td>
                                                <td>{{p.product_price}}</td>
                                                <td>{{p.product_stock}}</td>
                                                <td>{{p.product_weight}}</td>
                                                <td><a :href="'../assets/images/'+p.product_url" target="_blank">Link</a></td>
                                                <td>
                                                    <div class="dropdown no-arrow">
                                                        <a class="dropdown-toggle mr-2" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="float: right;">
                                                            <i class="fas fa-ellipsis-h fa-sm fa-fw text-gray-400"></i>
                                                        </a>
                                                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                                                            <div class="dropdown-header">Actions:</div>
                                                            <a class="dropdown-item" href="#">Preview</a>
                                                            <a class="dropdown-item" @click="editProduct(p)" href="#addEditProduct">Edit</a>
                                                            <button class="dropdown-item" data-toggle="dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Delete</button>
                                                            <div class="dropdown-menu shadow-danger mb-1">
                                                                <span class="dropdown-item">Confirm Deletion of post? This cannot be undone.</span>
                                                                <a class="dropdown-item text-success" href="#">Cancel</a>
                                                                <a class="dropdown-item text-danger" @click="deletePost(p.id)">Confirm Delete</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- List of Products -->
                        <div class="col-lg-12" style="display: none;">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">List of Products</h6>
                                </div>
                                <div class="card-body-products">
                                    <br>
                                    <div class="card-list-products">

                                        <div class="card-products" v-for="p in products">
                                            <div class="card-image-products">
                                                <img width="100px" :src="'../assets/images/'+p.product_url" alt="Product of Pharmacy">
                                            </div>
                                            <div class="dropdown no-arrow">
                                                <a class="dropdown-toggle mr-2" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="float: right;">
                                                    <i class="fas fa-ellipsis-h fa-sm fa-fw text-gray-400"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                                                    <div class="dropdown-header">Actions:</div>
                                                    <a class="dropdown-item" href="#">Preview</a>
                                                    <a class="dropdown-item" @click="editProduct(p)" href="#addEditProduct">Edit</a>
                                                    <button class="dropdown-item" data-toggle="dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Delete</button>
                                                    <div class="dropdown-menu shadow-danger mb-1">
                                                        <span class="dropdown-item">Confirm Deletion of post? This cannot be undone.</span>
                                                        <a class="dropdown-item text-success" href="#">Cancel</a>
                                                        <a class="dropdown-item text-danger" @click="deletePost(p.id)">Confirm Delete</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-body-products">
                                                <h4 class="h4">{{p.product_name}}</h4>
                                                <p>
                                                    {{p.product_description}}
                                                </p>
                                            </div>
                                        </div>

                                    </div>
                                    <br>
                                </div>
                            </div>

                        </div>

                        <div class="col-lg-6" style="display: none;">
                            <!-- Dropdown Card Example -->
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Dropdown Card Example</h6>
                                    <div class="dropdown no-arrow">
                                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                                            <div class="dropdown-header">Dropdown Header:</div>
                                            <a class="dropdown-item" href="#">Action</a>
                                            <a class="dropdown-item" href="#">Another action</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="#">Something else here</a>
                                        </div>
                                    </div>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    Dropdown menus can be placed in the card header in order to extend the functionality
                                    of a basic card. In this dropdown card example, the Font Awesome vertical ellipsis
                                    icon in the card header can be clicked on in order to toggle a dropdown menu.
                                </div>
                            </div>

                            <!-- Collapsable Card Example -->
                            <div class="card shadow mb-4">
                                <!-- Card Header - Accordion -->
                                <a href="#collapseCardExample" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample">
                                    <h6 class="m-0 font-weight-bold text-primary">Collapsable Card Example</h6>
                                </a>
                                <!-- Card Content - Collapse -->
                                <div class="collapse show" id="collapseCardExample">
                                    <div class="card-body">
                                        This is a collapsable card example using Bootstrap's built in collapse
                                        functionality. <strong>Click on the card header</strong> to see the card body
                                        collapse and expand!
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->

        <?php include("footer.php"); ?>
        <!-- Start scripts here -->

        <!-- Bootstrap core JavaScript-->
        <script src="../vendor/jquery/jquery.min.js"></script>
        <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

        <!-- Core plugin JavaScript-->
        <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

        <!-- Custom scripts for all pages-->
        <script src="../js/sb-admin-2.min.js"></script>

        <!-- Page level plugins -->
        <script src="../vendor/datatables/jquery.dataTables.min.js"></script>
        <script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>

        <!-- Page level custom scripts -->
        <script src="../js/demo/datatables-demo.js"></script>

        <script>
            new Vue({
                el: "#vueApp",
                data() {
                    return {
                        editStoreName: false,
                        store_name: "",

                        //Product
                        name: null,
                        description: null,
                        category: 1,
                        stock: null,
                        price: 0,
                        weight: 0,
                        brand: null,
                        isEditProduct: false,

                        //Product list
                        products: [],
                        product_id: null,
                        //Notification
                        showNotification: false,
                        messageNotification: null,
                        isSaving: false,
                        saveBtnProduct: "Save Product Information",
                        updateBtnProduct: "Update Product Information",

                    }
                },
                methods: {

                    //Post Product
                    async postProduct() {
                        this.isSaving = true;
                        this.saveBtnProduct = "Saving...";
                        this.showNotification = true;
                        this.messageNotification = "Uploading Product...";
                        var pictureFile = document.querySelector("#picture");
                        console.log(pictureFile.files[0]);
                        const form = new FormData();
                        form.append("picture", pictureFile.files[0]);
                        form.append("name", this.name);
                        form.append("description", this.description);
                        form.append("category", this.category);
                        form.append("stock", this.stock);
                        form.append("price", this.price);
                        form.append("weight", this.weight);
                        form.append("brand", this.brand);

                        const options = {
                            method: "POST",
                            url: "process_pharmacy.php?createProduct=" + <?php echo $id; ?>,
                            headers: {
                                "Content-Type": "multipart/form-data",
                            },
                            data: form
                        };

                        await axios.request(options).then((response) => {
                            this.name = null;
                            this.description = null;
                            this.stock = null;
                            document.querySelector("#picture").value = "";
                            this.showNotification = true;
                            this.brand = "";
                            this.weight = 0;
                            this.price = 0;
                            this.messageNotification = "Uploading of product succesful!";
                            this.getProducts();

                        }).catch((error) => {
                            console.error(error);
                            this.showNotification = true;
                            this.messageNotification = "There is an error uploading the product. Please try again.";
                        });

                        this.isSaving = false;
                        this.saveBtnProduct = "Save Product Information";
                    },

                    //Update Product
                    async updateProduct() {
                        this.showNotification = true;
                        this.messageNotification = "Uploading Product...";
                        var pictureFile = document.querySelector("#picture");
                        console.log(pictureFile.files[0]);
                        const form = new FormData();
                        form.append("picture", pictureFile.files[0]);
                        form.append("name", this.name);
                        form.append("description", this.description);
                        form.append("category", this.category);
                        form.append("stock", this.stock);
                        form.append("price", this.price);
                        form.append("weight", this.weight);
                        form.append("brand", this.brand);

                        const options = {
                            method: "POST",
                            url: "process_pharmacy.php?updateProduct=" + this.product_id,
                            headers: {
                                "Content-Type": "multipart/form-data",
                            },
                            data: form
                        };

                        await axios.request(options).then((response) => {
                            this.name = null;
                            this.description = null;
                            this.stock = null;
                            document.querySelector("#picture").value = "";
                            this.showNotification = true;
                            this.brand = "";
                            this.weight = 0;
                            this.price = 0;
                            this.messageNotification = "Updating of product succesful!";
                            this.getProducts();

                        }).catch((error) => {
                            console.error(error);
                            this.showNotification = true;
                            this.messageNotification = "There is an error uploading the product. Please try again.";
                        });
                        this.isEditProduct = false;

                    },

                    // Edit Product
                    editProduct(product) {
                        this.isEditProduct = true;
                        this.name = product.product_name;
                        this.description = product.product_description;
                        this.stock = product.product_stock;
                        this.brand = product.product_brand;
                        this.weight = product.product_weight;
                        this.price = product.product_price;
                        this.product_id = product.id;
                    },

                    //Cancel Edit Product
                    cancelEditProduct() {
                        this.isEditProduct = false;
                        this.name = null;
                        this.description = null;
                        this.stock = null;
                        document.querySelector("#picture").value = "";
                    },

                    //Delete Product
                    async deletePost(id) {
                        const options = {
                            method: "POST",
                            url: "process_pharmacy.php?deleteProduct=" + id,
                            headers: {
                                Accept: "application/json",
                            },
                            data: {
                                productId: id,
                            },
                        };
                        await axios
                            .request(options)
                            .then((response) => {
                                console.log(response);
                                this.showNotification = true;
                                this.messageNotification = response.data.response;
                                this.getProducts();
                            })
                            .catch((error) => {
                                console.log(error);
                            });
                    },
                    //Get Products
                    async getProducts() {
                        const options = {
                            method: "GET",
                            url: "process_store.php?getProducts=" + <?php echo $id; ?>,
                            headers: {
                                Accept: "application/json",
                            },
                        };
                        await axios
                            .request(options)
                            .then((response) => {
                                this.products = response.data;
                                console.log(this.products);
                            })
                            .catch((error) => {
                                console.log(error);
                            });
                    },

                },
                async created() {
                    //Get Products
                    await this.getProducts();
                },

            });
        </script>
</body>

</html>