import React, { Component } from "react";
import ReactDOM from "react-dom";
import axios from "axios";
import Swal from "sweetalert2";
import { sum } from "lodash";
import Select from "react-select";

class Cart extends Component {
    constructor(props) {
        super(props);
        this.state = {
            cart: [],
            products: [],
            customers: [],
            barcode: "",
            search: "",
            customer_id: "",
            patient: {
                name: "Walk-in",
                bed_number: "N/A",
                doctor: "N/A",
                nurse: "N/A",
                date: new Date().toISOString().split("T")[0],
            },
            stations: {
                one: 1,
                two: 2,
                three: 3,
                four: 4,
                five: 5,
                six: 6,
            },
            station_id: 1,
        };

        this.selectRef = React.createRef();
        this.handleReset = this.handleReset.bind(this);

        this.loadCart = this.loadCart.bind(this);
        this.handleOnChangeBarcode = this.handleOnChangeBarcode.bind(this);
        this.handleOnChangeStation = this.handleOnChangeStation.bind(this);
        this.handleScanBarcode = this.handleScanBarcode.bind(this);
        this.handleChangeQty = this.handleChangeQty.bind(this);
        this.handleEmptyCart = this.handleEmptyCart.bind(this);

        this.loadProducts = this.loadProducts.bind(this);
        this.handleChangeSearch = this.handleChangeSearch.bind(this);
        this.handleSeach = this.handleSeach.bind(this);
        this.resetCustomerId = this.resetCustomerId.bind(this);
        this.setCustomerId = this.setCustomerId.bind(this);
        this.handleClickSubmit = this.handleClickSubmit.bind(this);
    }

    componentDidMount() {
        // load user cart
        this.loadCart();
        this.loadProducts();
        this.loadCustomers();
    }

    loadCustomers() {
        axios.get(`/admin/customers`).then((res) => {
            const customers = res.data;
            this.setState({ customers });
        });
    }

    loadProducts(search = "") {
        const query = !!search ? `?search=${search}` : "";
        axios.get(`/admin/products${query}`).then((res) => {
            const products = res.data.data;
            this.setState({ products });
        });
    }

    handleOnChangeBarcode(event) {
        const barcode = event.target.value;
        console.log(barcode);
        this.setState({ barcode });
    }
    handleOnChangeStation(event) {
        const station = event.target.value;
        this.setState({ station_id: station });
    }

    loadCart() {
        axios.get("/admin/cart").then((res) => {
            const cart = res.data;
            this.setState({ cart });
        });
    }

    handleScanBarcode(event) {
        event.preventDefault();
        const { barcode } = this.state;
        if (!!barcode) {
            axios
                .post("/admin/cart", { barcode })
                .then((res) => {
                    this.loadCart();
                    this.setState({ barcode: "" });
                })
                .catch((err) => {
                    Swal.fire("Error!", err.response.data.message, "error");
                });
        }
    }
    handleChangeQty(product_id, qty) {
        const cart = this.state.cart.map((c) => {
            if (c.id === product_id) {
                c.pivot.quantity = qty;
            }
            return c;
        });

        this.setState({ cart });

        axios
            .post("/admin/cart/change-qty", { product_id, quantity: qty })
            .then((res) => {})
            .catch((err) => {
                Swal.fire("Error!", err.response.data.message, "error");
            });
    }

    getTotal(cart) {
        const total = cart.map((c) => c.pivot.quantity * c.price);
        return sum(total).toFixed(2);
    }
    handleClickDelete(product_id) {
        axios
            .post("/admin/cart/delete", { product_id, _method: "DELETE" })
            .then((res) => {
                const cart = this.state.cart.filter((c) => c.id !== product_id);
                this.setState({ cart });
            });
    }
    handleEmptyCart() {
        axios.post("/admin/cart/empty", { _method: "DELETE" }).then((res) => {
            this.setState({ cart: [] });
        });
    }
    handleChangeSearch(event) {
        const search = event.target.value;
        this.setState({ search });
    }
    handleSeach(event) {
        if (event.keyCode === 13) {
            this.loadProducts(event.target.value);
        }
    }
    addProductToCart(barcode) {
        let product = this.state.products.find((p) => p.barcode === barcode);
        if (!!product) {
            // if product is already in cart
            let cart = this.state.cart.find((c) => c.id === product.id);
            if (!!cart) {
                // update quantity
                this.setState({
                    cart: this.state.cart.map((c) => {
                        if (
                            c.id === product.id &&
                            product.quantity > c.pivot.quantity
                        ) {
                            c.pivot.quantity = c.pivot.quantity + 1;
                        }
                        return c;
                    }),
                });
            } else {
                if (product.quantity > 0) {
                    product = {
                        ...product,
                        pivot: {
                            quantity: 1,
                            product_id: product.id,
                            user_id: 1,
                        },
                    };

                    this.setState({ cart: [...this.state.cart, product] });
                }
            }

            axios
                .post("/admin/cart", { barcode })
                .then((res) => {
                    // this.loadCart();
                })
                .catch((err) => {
                    Swal.fire("Error!", err.response.data.message, "error");
                });
        }
    }
    resetCustomerId() {
        this.state.customer_id = "";
    }
    handleReset() {
        this.selectRef.current.clearValue();
    }
    setCustomerId({ value }) {
        const selectedPatient = this.state.customers.find((cus) => {
            return cus.id == parseInt(value);
        });

        let patientDetails = {
            name: "Walk-in",
            bed_number: "N/A",
            doctor: "N/A",
            nurse: "N/A",
            date: new Date().toISOString().split("T")[0],
        };

        if (selectedPatient) {
            patientDetails = {
                name:
                    selectedPatient.first_name +
                    " " +
                    selectedPatient.last_name,
                bed_number: selectedPatient.room_number,
                doctor: selectedPatient.doctor_name,
                nurse: selectedPatient.name_of_nurse,
                date: new Date().toISOString().split("T")[0],
            };
        }

        this.setState({
            customer_id: value,
            patient: {
                ...patientDetails,
            },
        });
    }
    handleClickSubmit() {
        Swal.fire({
            html: `
            <ul class="list-group">
                <li class="list-group-item text-left">Patient Name: ${this.state.patient.name}</li>
                <li class="list-group-item text-left">Room #: ${this.state.patient.bed_number}</li>
                <li class="list-group-item text-left">Doctor's Name: ${this.state.patient.doctor}</li>
                <li class="list-group-item text-left">Nurse: ${this.state.patient.nurse}</li>
                <li class="list-group-item text-left">Station Number: ${this.state.station_id}</li>
            </u>`,
            showCancelButton: true,
            confirmButtonText: "Send",
            showLoaderOnConfirm: true,
            preConfirm: (amount) => {
                return axios
                    .post("/admin/orders", {
                        customer_id: this.state.customer_id,
                        station_id: this.state.station_id,
                        amount: 0,
                    })
                    .then((res) => {
                        this.loadCart();
                        return res.data;
                    })
                    .catch((err) => {
                        Swal.showValidationMessage(err.response.data.message);
                    });
            },
            allowOutsideClick: () => !Swal.isLoading(),
        }).then((result) => {
            if (result.value) {
                this.state.patient = {
                    name: "Walk-in",
                    bed_number: "N/A",
                    doctor: "N/A",
                    nurse: "N/A",
                    date: new Date().toISOString().split("T")[0],
                };
                this.handleReset();
            }
        });
    }
    render() {
        const {
            cart,
            products,
            customers,
            barcode,
            patient,
            stations,
            station_id,
            customer_id,
        } = this.state;
        return (
            <div className="row">
                <div className="col-md-6 col-lg-4">
                    <div className="row mb-2">
                        <div className="col">
                            <form onSubmit={this.handleScanBarcode}>
                                <input
                                    type="text"
                                    className="form-control"
                                    placeholder="Product Code..."
                                    value={barcode}
                                    onChange={this.handleOnChangeBarcode}
                                />
                            </form>
                        </div>
                        <div className="col">
                            <Select
                                ref={this.selectRef}
                                options={[
                                    { value: "", label: "Walk-in" },
                                    ...customers.map((cus) => ({
                                        value: cus.id,
                                        label: `${cus.first_name} ${cus.last_name}`,
                                    })),
                                ]}
                                onChange={this.setCustomerId}
                            />

                            {/* <select className="form-control">
                                <option value="">Walk-in Customer</option>
                                {customers.map((cus) => (
                                    <option
                                        key={cus.id}
                                        value={cus.id}
                                    >{`${cus.first_name} ${cus.last_name}`}</option>
                                ))}
                            </select> */}
                        </div>
                    </div>
                    <div className="user-cart">
                        <div
                            className="card"
                            style={{ minHeight: "600px", overflowY: "scroll" }}
                        >
                            <table className="table ">
                                <tr>
                                    <td>Patient Name:</td>
                                    <td>{patient.name}</td>
                                </tr>
                                <tr>
                                    <td>Room #:</td>
                                    <td>{patient.bed_number}</td>
                                </tr>
                                <tr>
                                    <td>Doctor's Name:</td>
                                    <td>{patient.doctor}</td>
                                </tr>
                                <tr>
                                    <td>Nurse:</td>
                                    <td>{patient.nurse}</td>
                                </tr>
                                <tr>
                                    <td>Date:</td>
                                    <td>{patient.date}</td>
                                </tr>
                                <tr>
                                    <td>Select Station</td>
                                    <td>
                                        <select
                                            className="custom-select"
                                            onChange={
                                                this.handleOnChangeStation
                                            }
                                        >
                                            {Object.entries(stations).map(
                                                ([name, value], index) => (
                                                    <option
                                                        key={index}
                                                        value={value}
                                                        selected={
                                                            value === station_id
                                                        }
                                                    >
                                                        {name}
                                                    </option>
                                                )
                                            )}
                                        </select>
                                    </td>
                                </tr>
                            </table>
                            <table className="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Quantity</th>
                                        <th>Dosage</th>
                                        <th className="text-right">Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {cart.map((c) => (
                                        <tr key={c.id}>
                                            <td>{c.name}</td>
                                            <td>
                                                <input
                                                    type="text"
                                                    className="form-control form-control-sm qty"
                                                    value={c.pivot.quantity}
                                                    onChange={(event) =>
                                                        this.handleChangeQty(
                                                            c.id,
                                                            event.target.value
                                                        )
                                                    }
                                                />
                                                <button
                                                    className="btn btn-danger btn-sm"
                                                    onClick={() =>
                                                        this.handleClickDelete(
                                                            c.id
                                                        )
                                                    }
                                                >
                                                    <i className="fas fa-trash"></i>
                                                </button>
                                            </td>
                                            <td>{c.dosage}</td>
                                            <td className="text-right">
                                                {window.APP.currency_symbol}{" "}
                                                {(
                                                    c.price * c.pivot.quantity
                                                ).toFixed(2)}
                                            </td>
                                        </tr>
                                    ))}
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div className="row">
                        <div className="col">Total:</div>
                        <div className="col text-right">
                            {window.APP.currency_symbol} {this.getTotal(cart)}
                        </div>
                    </div>
                    <div className="row">
                        <div className="col">
                            <button
                                type="button"
                                className="btn btn-danger btn-block"
                                onClick={this.handleEmptyCart}
                                disabled={!cart.length}
                            >
                                Cancel
                            </button>
                        </div>
                        <div className="col">
                            <button
                                type="button"
                                className="btn btn-primary btn-block"
                                disabled={!cart.length}
                                onClick={this.handleClickSubmit}
                            >
                                Submit
                            </button>
                        </div>
                    </div>
                </div>
                <div className="col-md-6 col-lg-8">
                    <div className="mb-2">
                        <input
                            type="text"
                            className="form-control"
                            placeholder="Search Product..."
                            onChange={this.handleChangeSearch}
                            onKeyDown={this.handleSeach}
                        />
                    </div>
                    
                    <div className="order-product">
                        {products.map((p) => (
                            <div
                            onClick={() => Swal.fire({
                                
                                html: `
                                <ul class="list-group">
                                <li class="list-group-item text-left">Generic Name: ${p.description}</li>
                                    <li class="list-group-item text-left">Brand Name: ${p.name}</li>
                                    
                                    <li class="list-group-item text-left">Dosage: ${p.dosage}</li>
                                    <li class="list-group-item text-left">Price: ${p.price}</li>
                                </u>`,
                                showDenyButton: true,
                                showCancelButton: true,
                                confirmButtonText: 'Add',
                                denyButtonText: `Close`,
                              }).then((result) => {
                                /* Read more about isConfirmed, isDenied below */
                                if (result.isConfirmed) {this.addProductToCart(p.barcode)
                                  
                                } else if (result.isDenied) {
                                 
                                }
                              })}
                            key={p.id}
                            className="item"
                        >
                            {/* <div
                                onClick={() => this.addProductToCart(p.barcode)}
                                key={p.id}
                                className="item"
                            > */}
                                <img
                                    src={p.image_url}
                                    class="rounded mx-auto d-block"
                                    alt=""
                                />

                                <h5
                                    style={
                                        window.APP.warning_quantity > p.quantity
                                            ? { color: "red" }
                                            : {}
                                    }
                                >
                                    {p.name}({p.quantity})
                                </h5>
                            </div>
                        ))}
                    </div>
                </div>
            </div>
        );
    }
}

export default Cart;

if (document.getElementById("cart")) {
    ReactDOM.render(<Cart />, document.getElementById("cart"));
}
