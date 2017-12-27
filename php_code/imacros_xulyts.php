' can mo san cac tab truoc
'view systan scala
VERSION BUILD=9030808 RECORDER=FX
TAB T=1

'Lay du lieu dau vao
PROMPT  NHAP_VAO_MA_TRUONG !VAR1

URL GOTO=https://thituyensinh.vn
'tim kiem
TAG XPATH="/html/body/div/form/div[1]/div[3]/div/div/div/div/div/div/div[2]/div/table[1]/tbody/tr[2]/td/table/tbody/tr[4]/td/div/div/div[1]/span/input" CONTENT={{!VAR1}}
TAG XPATH="/html/body/div/form/div[1]/div[3]/div/div/div/div/div/div/div[2]/div/table[1]/tbody/tr[2]/td/table/tbody/tr[4]/td/div/div/div[2]/button"
'click vao link, can hover truoc, sau do moi click vao
TAG XPATH="/html/body/div/form/div[1]/div[3]/div/div/div/div/div/div/div[2]/div/div[2]/div[2]/table/tbody/tr/td[3]/a" CONTENT=EVENT:MOUSEOVER
EVENT TYPE=CLICK XPATH="/html/body/div/form/div[1]/div[3]/div/div/div/div/div/div/div[2]/div/div[2]/div[2]/table/tbody/tr/td[3]/a" BUTTON=0

'click vao link download, hover truoc
TAG  XPATH="/html/body/div[1]/form/div[1]/div[3]/div/div/div/div/div/div/div[2]/div/div[4]/table/tbody/tr/td[3]/div/div/div/div[1]/div[4]/div[1]/div/div/table/tbody/tr/td[2]/div/div[1]/div[1]/table/tbody/tr/td/div/a" CONTENT=EVENT:MOUSEOVER
'ONDOWNLOAD FOLDER=* FILE=r.xlsx WAIT=YES
TAG  XPATH="/html/body/div[1]/form/div[1]/div[3]/div/div/div/div/div/div/div[2]/div/div[4]/table/tbody/tr/td[3]/div/div/div/div[1]/div[4]/div[1]/div/div/table/tbody/tr/td[2]/div/div[1]/div[1]/table/tbody/tr/td/div/a" 
'EVENT TYPE=CLICK   XPATH="/html/body/div[1]/form/div[1]/div[3]/div/div/div/div/div/div/div[2]/div/div[4]/table/tbody/tr/td[3]/div/div/div/div[1]/div[4]/div[1]/div/div/table/tbody/tr/td[2]/div/div[1]/div[1]/table/tbody/tr/td/div/a"  BUTTON=0'
'WAIT SECONDS=5
PAUSE
' ngung de save full html bang tay

'========== chuyen qua TAB t2, lay du lieu tu file php
'TAB OPEN, mo san tab 2 truoc
TAB T=2
'URL GOTO=http://localhost/test_code/vendor/thituyensinh_chrome.php
REFRESH
WAIT SECONDS=2

' nguyen phan nay da chuyen xuong phia duoi
'SET !EXTRACT_TEST_POPUP NO
'TAG POS=1 TYPE=DIV ATTR=ID:id-thong-tin-chung EXTRACT=HTM
'SET !EXTRACT NULL
'TAG POS=1 TYPE=TABLE ATTR=ID:table-ts-daihoc EXTRACT=HTM
'TAG POS=1 TYPE=DIV ATTR=ID:id-thong-tin-daydu EXTRACT=HTM



'========= chuyen qua tab T3 xu ly tren app tuyen sinh

'--- tim kiem va mo trang
TAB OPEN
TAB T=3
URL GOTO=https://apptuyensinh.com/tim-kiem
TAG POS=1 TYPE=INPUT:TEXT  ATTR=ID:searchin_ts_ten CONTENT={{!VAR1}}
TAG POS=1 TYPE=SELECT  ATTR=ID:searchin_ts_bac CONTENT=%1
TAG POS=1 TYPE=SELECT  ATTR=ID:searchin_ts_he CONTENT=%1
TAG POS=1 TYPE=INPUT:SUBMIT  ATTR=ID:timkiem_buton
TAG POS=1 TYPE=A ATTR=REL:edit-timkiem-ts-rel



'======== STEP 3  ====================== 
'---- ghi du lieu len form

SET !EXTRACT_TEST_POPUP NO

'TAB T=3  phia tren co roi
'URL GOTO=https://apptuyensinh.com/tim-kiem/form/truyensinh?id=1002

' thiet lap cac option truoc
TAG POS=1 TYPE=INPUT FORM=ID:seblod_form ATTR=ID:ts_namtuyensinh3 CONTENT=%4
TAG POS=1 TYPE=INPUT:CHECKBOX FORM=ID:seblod_form ATTR=ID:ts_optionmorong1 CONTENT=YES
TAG POS=1 TYPE=INPUT:CHECKBOX FORM=ID:seblod_form ATTR=ID:ts_hinhthuctuyen2 CONTENT=YES


'--------------- copy thong tin tu php sang form 
TAB T=2
TAG POS=1 TYPE=DIV ATTR=ID:id-thong-tin-chung EXTRACT=HTM
TAB T=3
TAG POS=1 TYPE=TEXTAREA FORM=ID:seblod_form ATTR=ID:ts_tincuatruong CONTENT="{{!EXTRACT}}"
SET !EXTRACT NULL
' ngung de xem cac thong tin va option them cho doi tuong tuyen sinh
PAUSE


'--------------- copy thong tin tu php sang form 
TAB T=2
TAG POS=1 TYPE=TABLE ATTR=ID:table-ts-daihoc EXTRACT=HTM
TAB T=3
'"{{!EXTRACT}}" co dau ngoac kep de giu tag br lai
TAG POS=1 TYPE=TEXTAREA FORM=ID:seblod_form ATTR=ID:ts_nganhtuyensinh3 CONTENT="{{!EXTRACT}}"
SET !EXTRACT NULL



'--------------- copy thong tin tu php sang form 
TAB T=2
TAG POS=1 TYPE=DIV ATTR=ID:id-thong-tin-daydu EXTRACT=HTM
TAB T=3
TAG POS=1 TYPE=TEXTAREA FORM=ID:seblod_form ATTR=ID:ts_artfulltext CONTENT="{{!EXTRACT}}"
SET !EXTRACT NULL



