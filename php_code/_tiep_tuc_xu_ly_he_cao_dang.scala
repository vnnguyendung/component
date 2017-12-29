' xu ly trong tinh huong da cap nhat dai hoc, co them thông tin cao dang, 
' yeu cau  mo sang form nhap lieu cho he cao dang

SET !EXTRACT_TEST_POPUP NO
TAB T=3 
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
TAG POS=1 TYPE=TABLE ATTR=ID:table-ts-caodang EXTRACT=HTM
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
