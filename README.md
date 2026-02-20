# Kodano_MobileCoupon

Moduł do obsługi kuponów dostępnych tylko z aplikacji mobilnej.

## Co robi?

Kupon oznaczony jako "Mobile Only":
- NIE działa na stronie sklepu
- Działa tylko z aplikacji mobilnej (nagłówek `X-Mobile-App: true`)
- Po użyciu z apki - działa też na stronie

---

## Jak ustawić?

**Marketing → Cart Price Rules → wybierz regułę → włącz "Mobile Only"**

<img width="1349" height="850" alt="image" src="https://github.com/user-attachments/assets/0ec4380a-6df6-4b1d-ab51-acfea7b89528" />

---

## API

### Lista kuponów mobile-only
```
GET /rest/V1/mobile-coupons
```

<img width="1162" height="614" alt="image" src="https://github.com/user-attachments/assets/15a62428-37e6-471f-9867-08f13069a94c" />



### Oznacz jako mobile-only
```
POST /rest/V1/mobile-coupons/{ruleId}
```


<img width="1201" height="619" alt="image" src="https://github.com/user-attachments/assets/1346f6c6-0f65-49ec-8b8d-1e1ac1d8f520" />

### Usuń flagę
```
DELETE /rest/V1/mobile-coupons/{ruleId}
```
<img width="1296" height="617" alt="image" src="https://github.com/user-attachments/assets/d38b67df-4072-428b-bd9a-3d543eb669b0" />

---

## Walidacja

### Z nagłówkiem → działa
<img width="1201" height="545" alt="image" src="https://github.com/user-attachments/assets/b7dc21f4-f849-4828-849c-4ed07bd2b8d5" />

### Bez nagłówka → błąd
<img width="1214" height="636" alt="image" src="https://github.com/user-attachments/assets/0057bae9-ebb0-4d12-88af-fb6ebff28e16" />

### Checkout
<img width="1377" height="408" alt="image" src="https://github.com/user-attachments/assets/9a854a25-818b-4965-b07d-4cc54ab99bbd" />

<img width="1400" height="594" alt="image" src="https://github.com/user-attachments/assets/73701580-3299-4f18-85f7-fdc81450cfd6" />


---

## Postman

Importuj `postman_collection.json`
## Testy

```bash
vendor/bin/phpunit -c dev/tests/unit/phpunit.xml.dist app/code/Kodano/MobileCoupon/Test/Unit/
```
