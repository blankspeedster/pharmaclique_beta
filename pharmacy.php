<?php
    require_once("process_pharmacy.php");
    include("head.php");

    $user_id = $_SESSION['user_id'];
    $checkStore = $mysqli->query("SELECT * FROM pharmacy_store WHERE user_id='$user_id' ");
    $storeExist = false;
    $storeId = 0;
    if (mysqli_num_rows($checkStore) > 0) {
        $storeExist = true;
        $store = $checkStore->fetch_array();
        $storeId = $store['id'];
    }
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
                            <h1 class="h3 mb-0 text-gray-800">Pharmacy</h1>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <!-- Collapsable Card Example -->
                                <div class="card shadow mb-4">
                                    <!-- Card Header - Accordion -->
                                    <a href="#collapseStore" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseStore">
                                        <h6 class="m-0 font-weight-bold text-primary">Storename</h6>
                                    </a>
                                    <!-- Card Content - Collapse -->
                                    <!-- <div class="collapse show" id="collapseCardExample"> -->
                                    <div class="collapse <?php if (!$storeExist) { echo "show"; } ?>" id="collapseStore">
                                        <div class="card-body">
                                            <form method="post" action="process_pharmacy.php">
                                                <div class="row">
                                                    <!-- Store Name -->
                                                    <div class="col-xl-6 col-md-6 mb-4">
                                                        <div class="row no-gutters align-items-center">
                                                            <div class="col mr-2">
                                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                                    Store Name</div>
                                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                                    <input :disabled="!editStoreName" type="text" class="form-control" name="store_name" value="<?php if ($storeExist) {echo $store['store_name'];} ?>" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Address -->
                                                    <div class="col-xl-6 col-md-6 mb-4">
                                                        <div class="row no-gutters align-items-center">
                                                            <div class="col mr-2">
                                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                                    Store Address</div>
                                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                                    <textarea :disabled="!editStoreName" class="form-control" name="address"><?php if ($storeExist) { echo $store['address']; } ?></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Description -->
                                                    <div class="col-xl-6 col-md-6 mb-4">
                                                        <div class="row no-gutters align-items-center">
                                                            <div class="col mr-2">
                                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                                    Description</div>
                                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                                    <textarea :disabled="!editStoreName" class="form-control" name="description"><?php if ($storeExist) { echo $store['description']; } ?></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-xl-12 col-md-12 mb-4" style="">
                                                        <?php if (!$storeExist) { ?>
                                                            <button type="submit" style="float: right;" class="btn btn-primary btn-sm m-1" :disabled="!editStoreName" name="save_storename">
                                                                <i class="far fa-save"></i> Save Store Information
                                                            </button>
                                                            <a v-if="!editStoreName" style="float: right;" class="btn btn-success btn-sm m-1" @click="editStoreName = true">
                                                                <i class="far fa-edit"></i> Edit
                                                            </a>
                                                            <a v-else style="float: right;" class="btn btn-warning btn-sm m-1" @click="editStoreName = false">
                                                                <i class="far fa-window-close"></i> Cancel
                                                            </a>
                                                        <?php } else { ?>
                                                            <input type="text" name="store_id" value="<?php echo $store['id']; ?>" style="visibility: hidden;">
                                                            <button type="submit" style="float: right;" class="btn btn-info btn-sm m-1" name="update_storename" :disabled="!editStoreName">
                                                                <i class="far fa-save"></i> Update Store Information
                                                            </button>
                                                            <a v-if="!editStoreName" style="float: right;" class="btn btn-success btn-sm m-1" @click="editStoreName = true">
                                                                <i class="far fa-edit"></i> Edit
                                                            </a>
                                                            <a v-else style="float: right;" class="btn btn-warning btn-sm m-1" @click="editStoreName = false">
                                                                <i class="far fa-window-close"></i> Cancel
                                                            </a>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">

                            <!-- Add Propducts - Collapsable -->
                            <div class="col-lg-12" id="addEditProduct">
                                <div class="card shadow mb-4">
                                    <!-- Card Header - Accordion -->
                                    <a href="#collapseAddProduct" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseAddProduct">
                                        <h6 v-if="!isEditProduct" class="m-0 font-weight-bold text-primary">Add Product</h6>
                                        <h6 v-else class="m-0 font-weight-bold text-primary">Edit Product - {{name}}</h6>
                                    </a>
                                    <!-- Card Content - Collapse -->
                                    <div class="collapse show" id="collapseAddProduct">
                                        <div class="card-body">
                                            <form @submit.prevent="postProduct" >
                                                <div class="row">
                                                    <!-- Product Photo -->
                                                    <div class="col-xl-6 col-md-6 mb-4">
                                                        <div class="row no-gutters align-items-center">
                                                            <div class="col mr-2">
                                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                                    Product Photo
                                                                </div>
                                                                <div class="mb-0 font-weight-bold text-gray-800">
                                                                    <input type="file" id="picture" ref="picture" accept=".jpg,.png,.jpeg" required/>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Product Name -->
                                                    <div class="col-xl-6 col-md-6 mb-4">
                                                        <div class="row no-gutters align-items-center">
                                                            <div class="col mr-2">
                                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                                    Product Name</div>
                                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                                    <input type="text" class="form-control" v-model="name" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Product Descripton -->
                                                    <div class="col-xl-6 col-md-6 mb-4">
                                                        <div class="row no-gutters align-items-center">
                                                            <div class="col mr-2">
                                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                                    Product Descripton</div>
                                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                                    <input type="text" class="form-control" v-model="description" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Product Stock -->
                                                    <div class="col-xl-6 col-md-6 mb-4">
                                                        <div class="row no-gutters align-items-center">
                                                            <div class="col mr-2">
                                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                                    Product Stock</div>
                                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                                    <input type="number" class="form-control" v-model="stock" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <!-- Submit Product -->
                                                    <div class="col-xl-12 col-md-12 col-sm-12 text-end">
                                                        <button v-if="!isEditProduct" style="float: right;" type="submit" class="btn btn-primary btn-sm m-1" :disabled="isSaving">
                                                            <i class="far fa-save"></i> {{saveBtnProduct}}
                                                        </button>
                                                        <span v-else>
                                                            <button style="float: right;" class="btn btn-info btn-sm m-1" @click="updateProduct">
                                                                <i class="far fa-save"></i> {{updateBtnProduct}}
                                                            </button>
                                                            <a style="float: right;" class="btn btn-warning btn-sm m-1" @click="cancelEditProduct">
                                                                Cancel
                                                            </a>                                                                                                                       
                                                        </span>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- List of Products -->
                            <div class="col-lg-12">
                                <div class="card shadow mb-4">
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                        <h6 class="m-0 font-weight-bold text-primary">List of Products</h6>
                                    </div>
                                    <div class="card-body-products">
                                        <br>
                                        <div class="card-list-products">

                                            <div class="card-products" v-for="p in products">
                                                <div class="card-image-products">
                                                    <img :src="'./assets/images/'+p.product_url" alt="Product of Pharmacy">
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

                                            <!-- <div class="card-products">
                                                <div class="card-image-products">
                                                    <img src="./images/img2.jpg" alt="New York trip">
                                                </div>
                                                <div class="card-body-products">
                                                    <h2>New York</h2>
                                                    <p>
                                                        Lorem ipsum, dolor sit amet consectetur adipisicing elit. Voluptate quaerat quasi repudiandae sed
                                                        debitis ad numquam aliquid quos rem delectus doloremque, eos quia. Harum, minus?
                                                    </p>
                                                </div>
                                            </div> -->
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
            <script src="vendor/jquery/jquery.min.js"></script>
            <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

            <!-- Core plugin JavaScript-->
            <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

            <!-- Custom scripts for all pages-->
            <script src="js/sb-admin-2.min.js"></script>
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
                            isEditProduct: false,

                            //Product list
                            products: [],

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
                        async postProduct(){
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

                            const options = {
                            method: "POST",
                            url: "process_pharmacy.php?createProduct="+<?php echo $storeId; ?>,
                            headers: {
                                "Content-Type": "multipart/form-data",
                            },
                                data: form
                            };

                            await axios.request(options).then((response)=>{
                                this.name = null;
                                this.description = null;
                                this.stock = null;
                                document.querySelector("#picture").value = "";
                                this.showNotification = true;
                                this.messageNotification = "Uploading or product succesful!";
                                this.getProducts();

                            }).catch((error)=>{
                                console.error(error);
                                this.showNotification = true;
                                this.messageNotification = "There is an error uploading the product. Please try again.";
                            });

                            this.isSaving = false;
                            this.saveBtnProduct = "Save Product Information";
                        },
                        
                        // Edit Product
                        editProduct(product){
                            this.isEditProduct = true;
                            this.name = product.product_name;
                            this.description = product.product_description;
                            this.stock = product.product_stock;
                        },

                        //Cancel Edit Product
                        cancelEditProduct(){
                            this.isEditProduct = false;
                            this.name = null;
                            this.description = null;
                            this.stock = null;
                            document.querySelector("#picture").value = "";
                        },

                        //Delete Product
                        async deletePost(id){
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
                        async getProducts(){
                            const options = {
                                method: "GET",
                                url: "process_pharmacy.php?getProducts=" + <?php echo $storeId; ?>,
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

                        //Update Product
                        async updateProduct(){
                            
                        }
                    },
                    async mounted() {
                        //Get Products
                        await this.getProducts();
                    }
                });
            </script>
            <style>
            * {
                margin    : 0;
                padding   : 0;
                box-sizing: border-box;
            }

            .card-list-products {
                width                : 90%;
                display              : grid;
                grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
                grid-gap             : 4em
            }

            .card-products,
            .card-body-products,
            .card-footer-products {
                display       : flex;
                flex-direction: column;
                align-items   : center;
            }

            .card-products{
                border-radius: 18px;
                background   : #fff;
                box-shadow   : 2px 2px 20px rgba(0, 0, 0, 0.1);
                /* overflow     : hidden; */
                cursor       : pointer;
                transition   : transform 0.4s;
            }

            .card-products:hover {
                /* transform : scale(1.01); */
                /* box-shadow: 2px 2px 20px rgba(0, 0, 0, 0.1); */
            }

            .card-image-products {
                display  : block;
                position : relative;
                height   : 180px;
                max-width: 100%;
            }

            .card-image-products img {
                max-height     : 100%;
                width          : 100%;
                background-size: cover !important;
            }

            .card-body-products {
                padding: 5px 5px;
            }

            .card-body-products .date {
                font-weight: bolder;
            }

            .card-body-products h2 {
                margin   : 2px auto 12px;
            }

            .card-body-products p {
                color      : gray;
                line-height: 22px;
                text-align : center;
            }

            .card-footer-products {
                width                : 100%;
                display              : grid;
                grid-template-columns: 1fr 1fr 1fr;
            }

            .card-footer-products .info-products {
                font-size     : 0.9em;
                padding       : 10px;
                color         : #fff;
                display       : flex;
                flex-direction: column;
            }

            .card-footer-products .info-products:last-child {
                border: none;
            }

            .card-footer-products .info-products .type {
                text-transform: uppercase;
                margin-top    : 2px;
                font-size     : 0.8em;
            }

            .card-products:nth-child(1) .card-footer {
                background: #ff0c71;
            }

            .card-products:nth-child(1) .date {
                color: #ff0c71;
            }

            .card-products:nth-child(2) .card-footer {
                background: #ff510c;
            }

            .card-products:nth-child(2) .date {
                color: #ff510c;
            }

            .card-products:nth-child(3) .card-footer {
                background: #03b43e;
            }

            .card-products:nth-child(3) .date {
                color: #03b43e;
            }
            </style>
</body>

</html>