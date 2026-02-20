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


---

## API

### Lista kuponów mobile-only
```
GET /rest/V1/mobile-coupons
```

### Oznacz jako mobile-only
```
POST /rest/V1/mobile-coupons/{ruleId}
```

### Usuń flagę
```
DELETE /rest/V1/mobile-coupons/{ruleId}
```

---

## Walidacja

### Z nagłówkiem → działa

### Bez nagłówka → błąd

### Checkout

---

## Postman

Importuj `postman_collection.json`
## Testy

```bash
vendor/bin/phpunit -c dev/tests/unit/phpunit.xml.dist app/code/Kodano/MobileCoupon/Test/Unit/
```
