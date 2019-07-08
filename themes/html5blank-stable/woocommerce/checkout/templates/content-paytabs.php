<link rel="stylesheet" href="https://www.paytabs.com/theme/express_checkout/css/express.css">
			<!-- <script src="https://www.paytabs.com/theme/express_checkout/js/jquery-1.11.1.min.js"></script> -->
			<script src="https://www.paytabs.com/express/express_checkout_v3.js"></script>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			<!-- Button Code for PayTabs Express Checkout -->
			<div class="PT_express_checkout"></div>
			<script type="text/javascript">
			Paytabs("#express_checkout").expresscheckout({
			  settings: {
			    merchant_id: "10025196",
			    secret_key: "3sfVhpMBzWiTceRvo4DavsvxmO6E7Gda8t6pSS0rPjk2ycxXha7MCDkYrqDz6RJfkQEdIFFyY0Axc8utiBgVfAUG1xf8oZnJP1Wy",
			    amount: "10.00",
			    currency: "USD",
			    title: "Mr. John Doe",
			    product_names: "Product1,Product2,Product3",
			    order_id: 25,
			    url_redirect: "https://tomoori.sa/dev/paytabs-test-page/",
			    display_customer_info: 0,
			    display_billing_fields: 0,
			    display_shipping_fields: 0,
			    language: "en",
			    redirect_on_reject: 0,
			    style: {
			      css: "custom",
			      linktocss: "https://www.YOURSTORE.com/css/style.css"
			    },
			    is_iframe: {
			      load: "onbodyload",
			      show: 0
			    },
			    
			  },
			  customer_info: {
			    first_name: "John",
			    last_name: "Smith",
			    phone_number: "5486253",
			    email_address: "john@test.com",
			    country_code: "973"
			  },
			  billing_address: {
			    full_address: "Manama, Bahrain",
			    city: "Manama",
			    state: "Manama",
			    country: "BHR",
			    postal_code: "00973"
			  },
			  shipping_address: {
			    shipping_first_name: "Jane",
			    shipping_last_name: "Abdulla",
			    full_address_shipping: "Manama, Bahrain",
			    city_shipping: "Manama",
			    state_shipping: "Manama",
			    country_shipping: "BHR",
			    postal_code_shipping: "00973"
			  },
			  checkout_button: {
			    width: 150,
			    height: 30,
			    img_url: "http://www.clker.com/cliparts/1/2/x/X/a/Q/simple-gray-checkout-button-md.png"
			  },
			  pay_button: {
			    width: 150,
			    height: 30,
			    img_url: "https://previews.123rf.com/images/motortionfilms/motortionfilms1803/motortionfilms180301897/97823846-pay-now-web-interface-button-green-color-online-banking-service-shopping-stock-footage.jpg"
			  }
			});
			</script>