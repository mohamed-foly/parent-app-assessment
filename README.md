# Parent.App Assessment

## Endpoints
### /api/v1/users

- built to be dynamic.
  - reading all `.json` files from `providers` directory
  - cache scanned data till **1h** / files **changed** / file **modified**
  - sclable statuses by adding filter value into `statusValues` as `key` and allowed codes as `values`
-  built to be filterable.
   -  filter json files by file name Request Param: `provider`
   -  filter status by attribute name (status/statusCode) Request Param: `statusCode` 
   -  filter blance greater or equal value by attribute name (parentAmount/balance) Request Param: `balanceMin` 
   -  filter blance less or equal value by attribute name (parentAmount/balance) Request Param: `balanceMax` 
   -  filter currency by attribute name (currency/Currency) Request Param: `currency` 
   -  filter will apply as it sent in request params
   -  each filter can be applied isolated or compined with any other filter


