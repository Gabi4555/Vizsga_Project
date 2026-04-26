const Home = {
  props: ["products"],
data() {
  return { 
    slides: [
      {
        title: "Trustworthy Employees",
        text: "Only the best work here so you can be confident in what you see here is handled well.",
        image: "slidy/slidy1.jpg"
      },
      {
        title: "Only the Best",
        text: "In the name of quality we only sell the finest auto vehicles for everyone at the best price there is.",
        image: "slidy/slidy2.jpg"
      },
 
      {
        title: "Any place, Any time",
        text: "Let it be any place, time, or car  we will deliver.",
        image: "slidy/slidy3.jpg"
      },
      
    ],
    currentSlide: 0
  };
},
methods: { 
    closeBasket() {
      this.$root.isVisible = false;
    }
  },
  mounted() { 
    setInterval(() => {
      this.currentSlide = (this.currentSlide + 1) % this.slides.length;
    }, 4000);
    this.closeBasket();
  },
  computed: {
    featured() {
      if (!this.products) return [];
      return [...this.products].sort(() => 0.5 - Math.random()).slice(0, 3);
    }
  },
  //maga a weboldali rész
  template: `
<div>
<section class="hero">
  <div class="hero-slide" :key="currentSlide">
    <img 
        class="hero-bg"
        :src="slides[currentSlide].image"
    />

    <div class="hero-overlay">
      <h2>{{ slides[currentSlide].title }}</h2>
      <p>{{ slides[currentSlide].text }}</p>
    </div>
  </div>
</section>

<section class="section">
  <h2>Our bestselling categories!</h2>
</section>

<section class="section category-list">
        <div class="category-card" @click="$router.push('/category/S-segment Sports coupés')">S-segment Sports coupés</div>
        <div class="category-card" @click="$router.push('/category/E-segment executive cars')">E-segment executive cars</div>
         <div class="category-card" @click="$router.push('/category/F-segment luxury cars')">F-segment luxury cars</div>
</section>

<section class="section">
  <h2>Some cars we might think you'll like!</h2>
</section>

<section class="section">
  <div class="featured-grid">
    <div class="card feautred" v-for="item in featured" @click="$router.push('/product/' + item.id)">
      <img :src="$root.getImage(item)" />
      <h3>{{item.name}}</h3>
      <p class="price">$ {{ new Intl.NumberFormat('en-US').format(item.price) }}</p>
    </div>
  </div>
</section>
</div>
`
};
//kategóriák listája
const Categories = {
  props: ["categories"], //megkapjuk a kategóriák objektumot
  methods: {
    closeBasket() { //esztétikai változó
      this.$root.isVisible = false;
    }
  },
  mounted() { //nyitáskor lefutatja ezt
    this.closeBasket(); 
  },
  //maga a weboldal
  template: `
    <div class="products">
      
      <section class="section">
        <h2 class="section">Our incredible range of categories</h2>
      </section>

      <div class="category-list">
        <div 
          class="category-card"
          v-for="cat in categories"
          :key="cat.cname || cat"
          @click="$router.push('/category/' + (cat.cname || cat))"
        >
          {{ cat.cname || cat }}
        </div>
      </div>
    </div>
  `
};
//adott kategória termékei
const CategoryPage = {
  props: ["products"],
  computed: {
    filtered() {
  const name = this.$route.params.name;

  return this.products.filter(p => 
    p.car_category &&
    p.car_category.name === name
  );
}
  },
  methods: {
    closeBasket() {
      this.$root.isVisible = false;
    }
  },
    mounted() {
    this.closeBasket();
  },
  template: `
    <div class="products">
      <h2>{{ $route.params.name }}</h2>
      <div class="grid">
        <div class="card" v-for="item in filtered" @click="$router.push('/product/' + item.id)">
          <img :src="$root.getImage(item)" />
          <h3>{{item.name}}</h3>
          <p class="price">$ {{ new Intl.NumberFormat('en-US').format(item.price) }}</p>
        </div>
      </div>
    </div>
  `
};
//termék
const ProductPage = {
  props: ["products"],
  computed: {
    product() {
    return this.products.find(p => p.id == this.$route.params.id) || null; //megkeressük a fegyvert az adott ID-val
  },
    price() {
      return this.product.price;
    }
  },
  methods: {
    closeBasket() {
      this.$root.isVisible = false;
    },

    addToBasket(boughtItem, purchaseamount) {
      //megnézzünk jó sok kritériumot
      if (0 < purchaseamount && purchaseamount < 6 && purchaseamount != undefined && Number.isInteger(purchaseamount))  {
        //csekkoljuk van ez-e benne mér a listában
        const existing = this.$root.items.find(
        entry => entry.gun.id === boughtItem.id
        );
        //ha van akkor megnézzük lehet még rendelni
        if (existing) {
          //he nem akkor szólunk hogy már sokat rendelt az ember
          if (existing.quantity + purchaseamount > 5) {
              alert("Purchased amount cannot be more than 5!"); //szólunk hogy sikertelen a hozzáadás
          } else {
            //ha lehet akkor hozzáadjuk a rendeléshez
            existing.quantity += purchaseamount;
            alert("Your item has been added to your cart!"); //szólunk hogy sikeres a hozzáadás
          }
        } else  { //ha új a termék amit rendelünk akkor csak hozzáadjuk
          alert("Your item has been added to your cart!"); //szólunk hogy sikeres a hozzáadás
          this.$root.items.push({
          gun: boughtItem,
          quantity: purchaseamount,
          gunorderID: crypto.randomUUID()
          });
        }
      }
      //ha nem felelt meg a szabályoknak
      else {
        if (5 < purchaseamount){
          alert(`Purchased amount cannot be more than 5!`); //szólunk hogy sikertelen a hozzáadás
        }
        else if (1 > purchaseamount) {
          alert(`Purchased amount cannot be less than 1!`); //szólunk hogy sikertelen a hozzáadás
        }
        else {
          alert(`Please input a valid number!`); //szólunk hogy sikertelen a hozzáadás
        }
      }
      this.$root.updateSubtotal()
    }
  },
    mounted() {
    this.closeBasket();
  },
  //kedves weboldal része, valamiért a value nem írja ki magát de mindegy is bevallom
  template: `
    <div v-if="product" class="product-page">
      <img :src="$root.getImage(product)" />
    <div>
      <h2 class="product-name">{{product.name}}</h2>
      <table class:"product-info">

         <tr>
          <th class="product-specification"> year </th>
          <td class="product-data"> {{product.year}} </td>
        </tr>

         <tr>
          <th class="product-specification"> engine specifications </th>
          <td class="product-data"> {{product.engine.name}} </td>
        </tr>

         <tr>
          <th class="product-specification"> drivetrain </th>
          <td class="product-data"> {{product.drive.name}} </td>
        </tr>

        <tr>
          <th class="product-specification"> 0-60 </th>
          <td class="product-data"> {{product.acceleration}} </td>
        </tr>

        <tr>
          <th class="product-specification"> fuel efficiency</th>
          <td class="product-data"> {{product.fuel_efficiency}} </td>
        </tr>

      </table>
      <p class="price product-price">$ {{ new Intl.NumberFormat('en-US').format(price) }}</p>
      <p class="place-order" @click="addToBasket(product, purchasedAmount)">Add to cart.</p>
      <input class="order-amount" type="number" min="1" max="5" value="1" step="1" v-model="purchasedAmount"></input>
    </div>
    </div>
  `
};
//keresési eredmények
const SearchPage = {
  data() {
    return {
      results: [],
      loading: false
    };
  },
  methods: {
    closeBasket() {
      this.$root.isVisible = false;
    },
    fetchResults() {
      const query = this.$route.query.q;

      if (!query) return;

      this.loading = true;

      fetch("http://127.0.0.1:8000/api/car/search", {
        method: "POST",
        headers: {
          "Content-Type": "application/json"
        },
        body: JSON.stringify({
          name: query
        })
      })
      .then(res => res.json())
      .then(data => {
        this.results = data;
        console.log(data);
        this.loading = false;
      })
      .catch(err => {
        console.error(err);
        this.loading = false;
      });
}
  },
  watch: {
    '$route.query.q': 'fetchResults'
  },
  mounted() {
    this.fetchResults();
    this.closeBasket();
  },
  template: `
    <div class="products">
      <h2>Search: "{{ $route.query.q }}"</h2>

      <div v-if="loading">Searching...</div>

      <div v-else-if="results.length === 0">
        <p>No matches found.</p>
      </div>

      <div class="grid">
        <div 
          class="card" 
          v-for="item in results" 
          :key="item.id"
          @click="$router.push('/product/' + item.id)"
        >
          <img :src="$root.getImage(item)" />
          <h3>{{item.name}}</h3>
          <p class="price">$ {{ new Intl.NumberFormat('en-US').format(item.price) }}</p>
        </div>
      </div>
    </div>
  `
};
//rólunk
const About = {
  methods: {
    closeBasket() {
      this.$root.isVisible = false;
    }
  },
  mounted() {
    this.closeBasket();
  },
  template: `
    <div class="products">
    <div class="about">
      <h2>About Us:</h2>
      <p></p>
      
    </div>
    <div class="about">
    <h2>Meet The Team</h2>
      <div>
        <h1>Gábriel Újvárosi Katona</h1>
        <p>Hello Customers, I am the main developer of the Backend of this site who makes all this look easy and light!</p>
      </div>
      <div>
        <h1>Konor Fugolvits</h1>
        <p> I am the developer who built this site. </p>
        <p>I am the man who you should ask what you should get as your first car, as gift.</p>
      </div>
    </div>
    </div>
  `
};
//kosár
const Cart = {
  //fontos változók
  data() {
  return {
    paymentMethod: null, //fizetési metódus
    //postázási adatok
    country:"",
    city: "",
    street: "",
    house: "",
    //személyes adatok
    firstName: "",
    lastName: "",
    email: "",
    canCheckout: null, //megfigyelő mely intézi hogy nehogy az adatok megadása nékül csekkoljon ki a kedves emberünk
    orderItems: []
  };
  },
  computed: {
    items() {
      return this.$root.items; //megkapjuk az a kosár (items) változót számításra
    },
    subtotal() {
    return this.$root.items.reduce((sum, item) => {
      return sum + Number(item.gun.price)* item.quantity; //kiszámítjuk mennyi lesz a végösszeg a vendégnek
    }, 0);
    }
  },
  methods: {
    closeBasket() {
      this.$root.isVisible = false; //mint minden máshol, ez csak ilyen esztétikai funkció
    },
    //kosárból való kiszedés/törlés
    removeItem(id) {
      const item = this.$root.items.find(item => item.gunorderID === id); //megekressük azt a terméket amelyre az ID mutat

      if (!item) return; //ha nincs akkor semmit se teszünk

      //megnézzük mennyi van a kosárban
      //ha több mint 1 van akkor lefut az if
      if (item.quantity > 1) {
      item.quantity--; //kiszedünk egyet a kosárból
      } else {
        this.$root.items = this.$root.items.filter(item => item.gunorderID !== id); //teljesen törljük ezt a terméket
      }

      this.$root.updateSubtotal()
    },
    //kosárhoz való hozáadás
    addItem(id) {  
      const item = this.$root.items.find(item => item.gunorderID === id); //megekressük azt a terméket amelyre az ID mutat

      if (!item) return; //ha nincs akkor semmit se teszünk

      //megnézzük mennyi van a kosárban
      if (item.quantity < 5) {
        item.quantity++; //beteszünk mégegyet a kosárba
      }
      else {
        alert(`Purchased amount cannot be more than 5!`); //szólunk, hogy csak max 5 darabot lehet venni belőle
      }
      this.$root.updateSubtotal()
    },
    //csekkoljuk hogy minden mező ki van-e töltve
    purchaseCheck() {
      if (
        this.paymentMethod &&
        this.country &&
        this.city &&
        this.street &&
        this.house &&
        this.firstName &&
        this.lastName &&
        this.email
      ) 
      {
        this.canCheckout = true; //mehet a checoókout
      }
      else 
      {
        this.canCheckout = false; //hiányos valami a mezőben
      }

      this.orderItemCreation(this.canCheckout); //átküldjük a canCheckout státuszát
    },
    //megcsinálunk egy tömböt amely tartalmazza a rendelt termékeket id és mennyiségre lebontva, persze ha minden mező ki lett töltve
    orderItemCreation(status) {
      if (status) {
        this.$root.items.forEach(item => {
        this.orderItems[item.car.id] = item.quantity;
      });

      console.log(this.orderItems)
      this.purchaseCompletion();  
      }
    },
    //vásárlás véglegesítése vagy felhasználó szólítása ha nincs valami rendben
    purchaseCompletion() {
        fetch("http://127.0.0.1:8000/api/Orders/create", {
        method: "POST",
        headers: {
          "Content-Type": "application/json"
        },
        body: JSON.stringify({
          "payment_method" : this.paymentMethod,
          "country" : this.country,
          "city": this.city,
          "street" : this.street,
          "cars": this.orderItems,
          "house" : this.house,
          "firstName" : this.firstName,
          "lastName" : this.lastName
        }),
        })
        .then(async res => {
  const text = await res.text();
  console.log("STATUS:", res.status);
  console.log("RESPONSE:", text);
})
        .then(data => {
          this.results = data;
          this.loading = false;
        })
        .catch(err => {
          console.error(err);
          this.loading = false;
        });

        this.$root.items = []; //kosár törlése
        this.sendToHome();
    },
    sendToHome(){
      //átdobjuk a felhasználót egy másik oldalra
        this.$router.push({
        path: '/order_sucess',
        });
    }
  },
  mounted() {
    this.closeBasket(); //lefutatjuk ezt amikor megnyitjuk ezt a részét az oldalnak
  },
  //maga a weboldali rész
  template: `
  <section class="cart-list">
    <h2>Cart:</h2>
  </section>

  <div class="cart-view">
    <section class="section cart-items">
      <div class="cart-grid">
        <div v-if="items.length === 0" class="empty-cart">
          Your cart is empty
        </div>
        <div class="cart-item" v-for="cartItem in items" :key="cartItem.gunorderID">
          <img :src="$root.getImage(cartItem.gun)" />
          <div>
            <h3 class="subtotal">{{cartItem.gun.name}}</h3>
            <p>$ {{ new Intl.NumberFormat('en-US').format(cartItem.gun.price) }}</p>
            <p class="cart-quantity-control" @click="addItem(cartItem.gunorderID)">+</p>
            <p class="cart-quantity">x{{cartItem.quantity}}</p>
            <p class="cart-quantity-control" @click="removeItem(cartItem.gunorderID)">-</p>
        </div>
      </div>
    </div>
    </section>

    <section class="checkout" v-if="items.length != 0">
      <h3>Subtotal</h3>
      <p class="overall-price">$ {{new Intl.NumberFormat('en-US').format(subtotal.toFixed(2)) }}</p>
      <h3>Please specify your payment method:</h3>
      <div class="payment-method">
        <input type="radio" value="Cash" v-model="paymentMethod" />
        <label for="Cash">Cash</label>
        <input type="radio" value="BankTransfer" v-model="paymentMethod" />
        <labe for="Crypto">Bank Transfer</label>
      </div>

      <h3>Shipping address:</h3>
      <div>
      <p>Country:</p>
      <input type="text" placeholder="Country" v-model="country"></input>
      <p>Postal Code and City:</p>
      <input type="text" placeholder="Postal Code and City" v-model="city"></input>
      <p>Street Name:</p>
      <input type="text" placeholder="Street Name" v-model="street"></input>
      <p>House Number</p>
      <input type="text" placeholder="House Number" v-model="house"></input>
      </div>

      <h3>Client info:</h3>
      <div>
      <p>First Name:</p>
      <input type="text" placeholder="First Name" v-model="firstName"></input>
      <p>Last Name:</p>
      <input type="text" placeholder="Last Name" v-model="lastName"></input>
      <p>Email Adress:</p>
      <input type="email" placeholder="E-mail Adress" v-model="email"></input>
      </div>
      <p class="incomplete-fields" v-if="canCheckout === false">Please fill out all the fields!</p>
      <p class="purchase" @click="purchaseCheck">Purchase!</p>
    </section>

  </div>`
};
//vásárlás végét mutató rész
const CheckoutResult = {
  methods: {
    closeBasket() {
      this.$root.isVisible = false;
    },
    //2 másodperc mulva visszadobjuk az embert a főoldalra
    goToHome() {
      setTimeout(() => {
      this.$router.push({
      path: '/',
      });
    }, 2000);
    }
  },
  mounted() {
    this.closeBasket();
    this.goToHome();
  },
  template: `
    <div class="products">
    <div class="about">
      <h2>Thank you for your purchase! We will soon ship your item!</h2>
    </div>
    </div>
  `
}

//weboldal részek
const routes = [
  { path: '/', component: Home, props: true },
  { path: '/categories', component: Categories, props: true },
  { path: '/category/:name', component: CategoryPage, props: true },
  { path: '/product/:id', component: ProductPage, props: true },
  { path: '/search', component: SearchPage, props: true },
  { path: '/about', component: About },
  { path: '/cart',component: Cart, props: true},
  { path: '/order_sucess',component: CheckoutResult}
];

const router = VueRouter.createRouter({
  history: VueRouter.createWebHashHistory(),
  routes
});

const app = Vue.createApp({
  //ezek nagyon fontos változók lesznek
  data() {
    return {
      products: [], //termékek tömbje
      searchQuery: "", //a keresett szöveg
      categories: [], //kategóriák tömbje
      countries: [], //országok tömbje
      basket: [], //vásárlói kosár
      isVisible: false, //kosár láthatósága
      items: [], //kosár tartalma
      subtotal:  0
    };
  },

  //metódusok
  methods: {

    //termékhez valő képet megkapjuk
    getImage(item) {
    //az adott fegyverkategóriás képét adja vissza
    return `carCategoryImages/${item.car_category.name}.jpg`;
    },

    //megszerezzük az összes terméket
    fetchProducts() {
      fetch("http://127.0.0.1:8000/api/car/all")
        .then(res => res.json())
        .then(data => {
          this.products = data;
          //console.log(data);
      });
    },

    //megszerezzük az összes kategóriát
    fetchCategories() {
      fetch("http://127.0.0.1:8000/api/carCategories/all/name")
        .then(res => res.json())
        .then(data => {
          this.categories = data;
          //console.log(data);
      });
    },

    //
    goSearch() {
      //
      const query = this.searchQuery.trim();
      if (!query) return;

      //
      this.$router.push({
        path: '/search',
        query: { q: query }
      });
    },

    //a kosár kinyitása vagy eltüntetése
    openBasket(){
      this.isVisible = !this.isVisible;
    },

    //instant kosárból törlés
    deleteFromCart(id) {
      const item = this.$root.items.find(item => item.gunorderID === id); //megekressük azt a terméket amelyre az ID mutat

      if (!item) return; //ha nincs akkor semmit se teszünk
      this.$root.items = this.$root.items.filter(item => item.gunorderID !== id); //teljesen törljük ezt a terméket
    },

    updateSubtotal() {
      this.subtotal = this.items.reduce((sum, item) => {
      return sum + Number(item.gun.price)* item.quantity; //kiszámítjuk mennyi lesz a végösszeg a vendégnek
    }, 0) //kosár összege
    }
  },

  //ezeket a funkciókat idításkor lefuttatjuk
  mounted() {
    this.fetchProducts();
    this.fetchCategories();
  }
});

app.use(router);
app.mount("#app");