export const myMixin = {
  data() {
    return {
      storage: window.localStorage
    };
  },
  mounted() {},
  
  methods: {
    testMixin() {
      return alert('Mixin is called.');
    },
    addToCart: function () {
      console.log('this is test add to cart function');
    },

    addToWishlist: function (item) {
      if (this.storage.getItem('user')) {
        if (JSON.parse(this.storage.getItem('user')).level == 2) {
          var url = 'addToWishlist_dealer';
        }else {
          var url = 'addToWishlist';
        }

        var user = JSON.parse(this.storage.getItem('user')).id;

        this.$http.post('/api/' + url, {user: user, item: item}).then(response => {
          if (response.data.status == 'saved') {
            const h = this.$createElement;
            this.$notify({
              title: 'Succsesfully.',
              message: h('b', { style: 'color: teal' }, 'The item has been already put into Wishlist')
            });
          }else {
            const h = this.$createElement;
            this.$notify({
              title: 'Already in yor wishlist.',
              message: h('b', { style: 'color: teal' }, 'The item has been already in your Wishlist')
            });
          }
        }, response => {
          console.log('something error');
        });
      }else {
        var currentPath = this.$route.path;

        this.$store.commit('changeLoginDirect', currentPath);
        this.$router.push('/login');
      }
    },

    // addToCart
    addToCart_common(item) {
      console.log(item);
      if (item.onhand < 1) {
        this.$alert('Out of stock', 'Warning', {
          confirmButtonText: 'OK'
        });
      } else {
        if (window.localStorage.getItem(item.item)) {
          var qty = parseInt(window.localStorage.getItem(item.item)) + 1;
          window.localStorage.setItem(item.item, qty);
        } else {
          window.localStorage.setItem(item.item, 1);

          var newNumber = this.carts_number + 1;

          this.$store.commit('carts_number', newNumber);
        }
        // const h = this.$createElement;
        // this.$notify({
        //   title: 'Succsesfully.',
        //   message: h('b', { style: 'color: teal' }, 'The item has been already put into shopping cart')
        // })

        this.$confirm('', 'Congratulation', {
          confirmButtonText: 'Continue Shopping',
          cancelButtonText: 'Go to Shopping Cart',
          type: 'success',
          center: true
        }).then(() => {
          this.$router.push({ path: '/allProducts' });
        }).catch(() => {
          this.$router.push({ name: 'ShoppingCart' });
        });
      }
    },

    currentPath: function () {
      console.log(this.$route.path);
    },

    customerOrderHistory: function () {
      var id = JSON.parse(this.storage.getItem('user')).id;
      this.$http.get('/api/customerOrderHistory', { params: { 'id': id } }).then(response => {
        this.orderHistory = response.data.history;
        this.pending = response.data.pending;
      });
    },

    dealerOrderHistory: function () {
      var account = JSON.parse(this.storage.getItem('user')).account;
      this.$http.get('/api/dealerOrderHistory', { params: { 'account': account } }).then(response => {
        this.orderHistory = response.data.history;
        this.pending = response.data.pending;
        console.log(response.data);
      });
    },

    viewed: function (item) {
      this.$http.post('/api/viewed', { 'item': item }).then(response => {
        console.log(response);
      });
    },

    oneOrderDetails: function (so, id) {},

    myRange(start) {
      let end = (new Date()).getFullYear();
      let ar = [];
      let l = parseInt(end) - parseInt(start);
      for (let i = 0; i <= l; i++) {
        ar[i] = start;
        start++;
      }
      return ar;
    },

    myYear() {
      let start = (new Date()).getFullYear();
      let end = start + 10;
      let ar = [];
      let l = parseInt(end) - parseInt(start);
      for (let i = 0; i <= l; i++) {
        ar[i] = start;
        start++;
      }
      return ar;
    },

    isAlphaOrParen(a) {
      return /^[a-zA-Z()]+$/.test(a);
    },

    getGender(gender) {
      switch (gender) {
        case 1:
          return 'Male';
          break;
        case 2:
          return 'Famale';
          break;
        case 3:
          return 'I do not want to tell.';
          break;
        default: return 'Male';
          break;
      }
    },

    checkPwd(str) {
      if (str.length < 8) {
        return ('Password minimal length is 8.');
      } else if (str.length > 50) {
        return ('Password too long.');
      } else if (str.search(/\d/) == -1) {
        console.log('alphabet reqiured');
        return ('Password must contain number and alphabet.');
      } else if (str.search(/[a-zA-Z]/) == -1) {
        console.log('alphabet reqiured');
        return ('Password must contain number and alphabet.');
      } else if (str.search(/[^a-zA-Z0-9\!\@\#\$\%\^\&\*\(\)\_\+]/) != -1) {
        console.log('alphabet reqiured');
        return ('Password must contain number and alphabet.');
      }
      return ('ok');
    },

    Dealerprice(item) {
      let userInfo = JSON.parse(this.storage.getItem('userInfo'));
      let user = JSON.parse(this.storage.getItem('user'));
      let Dealerprice = item.pricel;

      if (user) {
        if (user.level == 2) {
          switch (userInfo.pricecode) {
            case '4':
              Dealerprice = item.price4;
              break;
            case '3':
              Dealerprice = item.price3;
              break;
            case '2':
              Dealerprice = item.price2;
              break;
            case '1':
              Dealerprice = item.price;
              break;
            default:
              Dealerprice = item.pricel;
              break;

          }
        } else {
        }
      }else {
      }

      return Dealerprice;
    }

  },
  computed: {
    carts_number() {
      return this.$store.state.carts_total;
    }
  }
};
