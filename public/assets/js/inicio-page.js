/* Generado desde nuevo_home.html — envuelto en IIFE para no contaminar
   el scope global del sitio. */
(function () {
(function(){

  /* ============ MAPA DE SUCURSALES ============ */
const DEPTS = {
 altoparaguay:{n:"Alto Paraguay",lbl:"ALTO PARAGUAY",lx:282.0,ly:145.6,d:"M329.5,99.0 L332.3,102.7 L329.8,103.5 L329.7,106.1 L333.8,106.9 L334.7,114.6 L341.0,118.8 L339.6,123.7 L341.6,137.9 L343.2,139.2 L343.8,136.6 L345.8,136.2 L349.7,140.7 L344.3,145.3 L349.7,148.1 L346.0,153.6 L352.6,157.1 L350.2,163.3 L351.5,173.3 L346.7,180.8 L350.0,184.9 L343.7,198.0 L346.2,202.1 L344.7,207.7 L347.3,211.2 L344.4,216.2 L343.2,223.2 L345.3,227.2 L341.0,237.8 L342.6,253.1 L347.9,255.5 L352.0,262.8 L350.5,265.3 L327.1,254.9 L325.2,250.0 L322.5,248.8 L261.3,246.0 L244.3,237.6 L209.3,237.2 L207.9,226.7 L215.1,195.1 L225.7,185.2 L222.9,165.6 L216.8,155.7 L216.4,149.5 L213.6,144.8 L214.9,138.3 L208.4,134.9 L82.2,96.6 L75.0,91.7 L87.7,60.3 L204.7,35.2 L266.6,34.3 L328.4,73.7 L330.7,86.9 L329.5,99.0 Z"},
 boqueron:{n:"Boquerón",lbl:"BOQUERÓN",lx:114.2,ly:231.9,d:"M54.2,275.1 L50.5,269.8 L45.1,268.4 L31.8,257.9 L27.7,256.6 L28.1,253.0 L26.0,251.4 L51.3,165.4 L51.8,127.6 L75.0,91.7 L82.2,96.6 L208.4,134.9 L214.9,138.3 L213.6,144.8 L216.4,149.5 L216.8,155.7 L222.9,165.6 L225.7,185.2 L215.1,195.1 L207.9,226.7 L209.3,237.2 L244.3,237.6 L249.6,240.3 L252.1,248.6 L245.1,253.3 L241.3,251.1 L232.5,255.9 L230.5,258.9 L231.0,264.5 L222.9,266.5 L222.6,273.1 L208.9,294.2 L208.3,312.0 L206.0,319.8 L206.9,322.9 L202.1,335.2 L200.8,344.7 L191.9,349.3 L167.7,351.0 L154.4,355.4 L151.6,362.2 L151.9,372.2 L148.5,372.0 L141.8,367.8 L139.2,368.5 L129.5,356.9 L130.1,352.5 L119.1,346.4 L117.5,343.3 L103.7,337.9 L102.0,335.4 L102.7,333.2 L88.0,325.8 L85.5,320.0 L72.9,310.4 L69.6,306.3 L67.5,299.3 L57.2,286.3 L56.9,280.4 L52.9,278.6 L54.2,275.1 Z"},
 presidentehayes:{n:"Presidente Hayes",lbl:"PDTE. HAYES",lx:267.1,ly:368.6,d:"M163.1,373.8 L151.9,372.2 L151.6,362.2 L154.4,355.4 L167.7,351.0 L191.9,349.3 L200.8,344.6 L202.1,335.2 L206.9,322.9 L206.0,319.8 L208.2,313.3 L207.7,301.5 L209.5,292.8 L222.6,273.1 L223.3,265.9 L231.0,264.5 L231.6,256.8 L239.5,251.7 L245.1,253.3 L251.9,249.0 L249.6,240.3 L261.3,246.0 L322.5,248.8 L325.2,250.0 L327.1,254.9 L350.5,265.3 L351.7,275.4 L355.5,282.5 L347.3,283.1 L344.3,286.9 L354.3,297.3 L352.4,300.9 L355.6,304.9 L354.5,309.4 L359.6,314.1 L364.6,315.1 L365.6,320.0 L375.1,327.9 L373.8,333.1 L377.9,341.5 L377.4,350.1 L380.9,355.4 L389.2,361.7 L387.4,364.2 L388.8,366.3 L388.2,371.3 L384.6,375.8 L388.6,378.1 L389.7,383.7 L392.2,383.9 L392.1,388.5 L396.8,390.1 L393.0,397.7 L396.0,402.5 L399.0,418.3 L398.0,425.9 L401.7,431.4 L399.6,436.9 L395.8,437.6 L391.0,447.1 L393.2,447.9 L394.4,454.0 L388.6,453.8 L384.6,459.9 L379.3,463.4 L372.4,463.2 L369.3,471.5 L362.4,476.5 L356.1,467.5 L349.0,461.4 L341.4,460.6 L340.2,458.4 L331.9,456.1 L325.1,450.8 L317.6,454.5 L309.8,445.0 L285.6,438.7 L272.6,428.9 L252.7,419.3 L241.2,407.5 L231.4,402.8 L227.2,398.1 L202.8,382.0 L182.3,382.7 L166.1,377.4 L163.1,373.8 Z"},
 concepcion:{n:"Concepción",lbl:"CONCEPCIÓN",lx:396.7,ly:289.3,d:"M342.1,240.1 L344.3,242.9 L350.8,244.8 L355.6,242.1 L363.0,241.6 L366.3,247.2 L376.5,247.5 L381.8,249.9 L389.5,249.9 L393.4,248.0 L394.4,249.9 L402.1,251.7 L410.2,251.5 L410.5,252.9 L413.6,253.5 L414.4,251.6 L416.0,255.5 L436.1,260.8 L428.0,268.7 L426.6,273.4 L426.8,282.3 L431.3,294.4 L428.5,298.9 L438.9,298.7 L442.1,292.3 L448.0,290.4 L454.4,285.0 L456.5,285.4 L466.8,311.7 L466.5,316.0 L463.6,316.8 L462.4,323.6 L458.4,326.2 L455.4,332.6 L449.7,337.3 L439.9,340.5 L417.1,338.7 L389.3,344.7 L383.7,345.0 L377.7,342.8 L377.2,338.0 L373.8,333.1 L375.1,327.9 L365.6,320.0 L364.6,315.1 L359.6,314.1 L354.5,309.4 L355.6,304.9 L352.4,300.9 L354.3,297.3 L344.3,286.9 L347.3,283.1 L355.5,282.5 L351.7,275.4 L350.3,264.5 L351.7,262.0 L347.2,254.7 L343.2,254.0 L342.0,251.4 L342.1,240.1 Z"},
 amambay:{n:"Amambay",lbl:"AMAMBAY",lx:474.4,ly:303.4,d:"M446.9,239.7 L451.9,247.5 L460.9,254.5 L475.5,254.6 L483.9,257.5 L484.8,255.5 L491.6,263.0 L494.1,276.1 L500.9,281.2 L501.2,287.6 L498.6,297.2 L499.9,307.9 L506.8,324.7 L505.0,330.5 L508.3,335.8 L506.3,342.1 L506.9,346.9 L502.6,356.1 L494.3,359.5 L480.0,370.2 L474.1,371.5 L471.4,370.3 L475.0,368.1 L477.0,363.7 L476.6,357.6 L479.8,352.9 L479.9,347.2 L473.4,347.9 L472.6,351.0 L469.6,353.0 L467.7,351.6 L465.4,346.1 L472.5,339.0 L470.2,335.6 L470.3,332.2 L463.4,330.5 L455.1,332.8 L456.6,328.3 L462.4,323.6 L463.6,316.8 L466.4,316.4 L466.8,312.2 L456.8,285.8 L454.4,285.0 L448.0,290.4 L442.7,291.8 L438.9,298.7 L428.5,298.9 L431.3,294.4 L426.8,282.3 L426.6,273.4 L428.0,268.7 L436.1,260.8 L418.5,255.5 L420.6,252.6 L425.2,252.6 L427.1,250.0 L431.6,253.6 L431.2,251.7 L435.9,248.2 L440.2,241.5 L446.9,239.7 Z"},
 sanpedro:{n:"San Pedro",lbl:"SAN PEDRO",lx:432.9,ly:398.8,d:"M492.3,439.1 L478.8,443.5 L472.3,453.0 L461.2,444.5 L461.2,440.9 L459.4,439.2 L442.0,456.7 L435.2,451.6 L427.8,448.9 L407.9,452.8 L403.9,457.9 L393.4,454.3 L394.7,453.5 L393.2,447.9 L391.0,447.1 L395.8,437.6 L399.6,436.9 L401.7,431.4 L398.0,425.9 L399.0,418.3 L396.0,402.5 L393.0,397.7 L396.8,390.1 L392.1,388.5 L392.2,383.9 L389.7,383.7 L388.6,378.1 L384.6,375.8 L388.2,371.3 L388.8,366.3 L387.4,364.2 L389.2,361.7 L379.1,353.3 L376.8,346.7 L377.7,342.8 L383.7,345.0 L389.3,344.7 L417.1,338.7 L436.1,341.1 L448.1,338.1 L452.9,333.8 L459.0,331.6 L463.4,330.5 L469.7,331.7 L472.5,339.0 L465.4,346.1 L466.5,349.5 L469.6,353.0 L472.6,351.0 L473.4,347.9 L479.7,346.9 L479.9,352.0 L476.6,357.6 L477.1,363.3 L475.1,367.9 L471.4,370.3 L475.8,383.7 L465.6,391.8 L464.8,400.8 L468.4,409.1 L472.8,412.0 L478.1,420.6 L481.3,428.3 L492.3,439.1 Z"},
 canindeyu:{n:"Canindeyú",lbl:"CANINDEYÚ",lx:519.7,ly:394.9,d:"M506.9,346.9 L507.1,352.3 L512.9,362.0 L513.9,376.2 L518.2,380.7 L529.4,382.9 L546.8,379.2 L550.3,375.6 L567.4,367.1 L580.6,374.1 L585.7,380.4 L594.0,385.2 L588.0,392.5 L592.9,407.9 L588.0,418.1 L588.9,427.8 L586.4,435.4 L568.2,432.2 L565.4,428.5 L560.2,428.2 L557.1,430.7 L556.2,428.4 L551.2,427.6 L550.8,424.4 L548.7,422.9 L537.7,421.7 L536.6,416.3 L535.1,415.9 L508.5,421.9 L492.3,439.1 L488.0,436.4 L481.3,428.3 L472.8,412.0 L468.1,408.4 L464.8,400.8 L465.0,393.3 L466.9,390.0 L475.8,383.7 L471.4,370.3 L474.1,371.5 L481.7,369.5 L494.3,359.5 L502.6,356.1 L506.9,346.9 Z"},
 caaguazu:{n:"Caaguazú",lbl:"CAAGUAZÚ",lx:488.4,ly:466.8,d:"M472.3,453.0 L477.5,444.6 L492.3,439.1 L507.7,422.4 L527.6,418.5 L523.3,424.5 L522.7,435.2 L520.8,438.1 L520.7,452.2 L523.5,457.0 L530.2,458.7 L542.2,469.0 L542.0,472.0 L545.3,474.2 L546.4,480.0 L541.4,480.2 L539.5,476.1 L534.9,473.0 L534.6,476.0 L527.7,472.2 L507.2,501.3 L502.5,503.6 L499.0,501.9 L487.0,505.0 L480.8,500.1 L451.2,497.7 L441.7,500.8 L431.7,507.5 L428.6,506.6 L425.0,503.3 L420.4,492.9 L437.3,480.9 L442.0,456.7 L459.4,439.2 L461.2,440.9 L461.2,444.5 L472.3,453.0 Z"},
 cordillera:{n:"Cordillera",lbl:"CORDILLERA",lx:411.0,ly:475.4,d:"M442.0,456.7 L437.3,480.9 L420.4,492.9 L425.0,503.3 L421.0,502.1 L414.6,503.6 L416.1,499.9 L414.4,494.9 L400.8,493.2 L394.8,483.4 L391.2,483.9 L386.3,474.0 L377.1,463.4 L384.6,459.9 L388.6,453.8 L403.9,457.9 L407.9,452.8 L427.8,448.9 L435.2,451.6 L442.0,456.7 Z"},
 central:{n:"Central",lbl:"CENTRAL",lx:363.6,ly:505.3,d:"M364.7,500.5 L369.0,496.7 L370.2,489.0 L367.5,484.8 L371.4,478.6 L368.4,472.4 L372.4,463.2 L377.1,463.4 L386.3,474.0 L391.2,483.9 L394.8,483.4 L396.9,486.5 L392.2,489.9 L380.6,505.5 L378.8,511.7 L380.3,521.3 L373.8,529.6 L370.0,522.4 L360.7,515.0 L355.5,514.6 L355.0,517.8 L352.5,517.7 L353.7,516.4 L352.4,512.5 L357.8,508.3 L355.5,506.8 L356.9,504.7 L362.0,502.8 L362.7,500.2 L364.7,500.5 Z"},
 guaira:{n:"Guairá",lbl:"GUAIRÁ",lx:460.9,ly:522.9,d:"M451.2,497.7 L480.8,500.1 L487.0,505.0 L499.0,501.9 L500.8,503.0 L497.8,508.9 L494.4,509.0 L491.8,512.4 L473.2,521.0 L468.7,530.2 L464.9,532.0 L458.3,528.2 L451.2,529.5 L448.9,533.9 L442.8,535.3 L440.6,541.6 L435.8,541.7 L430.6,531.5 L430.2,527.7 L434.6,525.9 L434.9,524.0 L431.1,516.9 L430.1,509.8 L441.7,500.8 L451.2,497.7 Z"},
 caazapa:{n:"Caazapá",lbl:"CAAZAPÁ",lx:483.5,ly:544.4,d:"M500.8,503.0 L507.2,501.3 L509.9,496.1 L514.3,496.0 L516.0,501.0 L507.4,517.8 L508.6,526.8 L514.0,529.6 L522.8,528.2 L527.7,531.0 L526.8,532.9 L521.7,534.6 L521.0,541.6 L517.2,545.6 L510.3,550.6 L493.0,555.1 L485.8,563.0 L475.5,566.2 L468.5,577.8 L447.6,585.9 L436.7,582.0 L436.5,578.2 L432.2,577.6 L427.2,574.2 L422.5,568.6 L426.8,563.7 L435.8,541.7 L440.6,541.6 L442.8,535.3 L448.9,533.9 L451.2,529.5 L458.3,528.2 L464.9,532.0 L468.7,530.2 L473.2,521.0 L491.8,512.4 L494.4,509.0 L497.8,508.9 L500.8,503.0 Z"},
 paraguari:{n:"Paraguarí",lbl:"PARAGUARÍ",lx:407.9,ly:545.4,d:"M421.0,502.1 L431.7,507.5 L430.1,509.8 L430.5,514.6 L434.9,525.1 L430.2,528.6 L435.8,541.7 L426.8,563.7 L422.5,568.6 L420.0,564.9 L406.5,558.5 L401.7,560.8 L396.2,567.3 L395.2,571.6 L384.8,574.7 L370.8,569.3 L366.7,566.2 L360.2,559.2 L375.6,541.1 L373.8,529.6 L380.3,521.3 L379.1,509.5 L392.2,489.9 L396.9,486.5 L401.9,493.9 L414.4,494.9 L416.1,499.9 L414.6,503.6 L421.0,502.1 Z"},
 misiones:{n:"Misiones",lbl:"MISIONES",lx:401.5,ly:601.4,d:"M400.5,638.6 L394.9,638.1 L386.9,634.1 L394.6,609.5 L379.3,605.7 L366.0,589.0 L360.2,559.2 L369.8,568.9 L384.8,574.7 L395.2,571.6 L396.2,567.3 L401.7,560.8 L407.1,558.6 L420.0,564.9 L428.3,575.3 L437.0,578.8 L439.3,611.4 L431.2,616.4 L429.0,621.3 L428.9,624.1 L432.7,628.5 L432.3,635.8 L423.3,639.8 L414.3,633.3 L400.5,638.6 Z"},
 itapua:{n:"Itapúa",lbl:"ITAPÚA",lx:493.1,ly:596.2,d:"M565.6,546.4 L563.4,560.3 L557.2,567.7 L557.8,572.9 L556.0,577.5 L551.2,577.0 L548.4,578.4 L544.7,586.8 L538.9,588.1 L534.5,592.4 L533.6,599.0 L524.0,597.6 L515.0,601.0 L511.8,609.7 L506.9,609.8 L505.5,613.8 L502.6,614.8 L504.6,620.6 L503.0,626.6 L492.0,635.1 L485.3,632.0 L482.7,627.1 L467.0,624.5 L456.5,631.1 L456.1,636.4 L450.6,645.2 L446.3,644.8 L438.5,636.0 L432.3,635.8 L432.7,628.5 L428.9,624.1 L429.0,621.3 L431.2,616.4 L439.3,611.4 L436.7,582.0 L447.6,585.9 L468.5,577.8 L476.5,565.5 L485.8,563.0 L493.0,555.1 L510.3,550.6 L517.2,545.6 L521.0,541.6 L521.9,534.5 L527.0,543.4 L533.9,543.3 L541.2,546.2 L546.6,543.5 L550.3,539.4 L551.1,542.8 L557.3,541.6 L560.2,543.1 L560.9,545.9 L565.6,546.4 Z"},
 altoparana:{n:"Alto Paraná",lbl:"ALTO PARANÁ",lx:540,ly:548,d:"M570.2,484.4 L571.2,502.6 L567.8,503.2 L567.1,505.8 L570.7,516.5 L569.0,520.2 L569.6,524.9 L565.8,527.3 L567.2,533.4 L565.7,539.8 L567.4,543.3 L565.6,546.4 L560.9,545.9 L560.2,543.1 L557.3,541.6 L551.1,542.8 L550.3,539.4 L546.6,543.5 L541.2,546.2 L533.9,543.3 L527.0,543.4 L523.3,534.9 L527.4,532.3 L527.3,530.5 L522.4,528.1 L513.5,529.5 L508.6,526.8 L507.4,517.8 L516.1,500.5 L513.9,495.7 L509.9,496.1 L525.7,474.4 L528.4,472.2 L535.3,475.9 L534.9,473.0 L539.5,476.1 L541.4,480.2 L546.4,480.0 L545.3,474.2 L542.0,472.0 L542.2,469.0 L530.2,458.7 L523.5,457.0 L520.7,452.2 L520.8,438.1 L522.7,435.2 L523.3,424.5 L527.6,418.5 L536.6,416.3 L537.7,421.7 L548.7,422.9 L550.8,424.4 L551.2,427.6 L556.2,428.4 L557.1,430.7 L560.2,428.2 L565.4,428.5 L568.2,432.2 L586.4,435.4 L583.1,442.0 L579.3,457.9 L581.7,466.1 L570.2,484.4 Z"},
 neembucu:{n:"Ñeembucú",lbl:"ÑEEMBUCÚ",lx:343.5,ly:577.3,d:"M331.9,543.7 L334.4,538.2 L348.9,529.6 L349.8,527.4 L346.6,526.5 L350.3,522.0 L348.7,519.7 L355.0,517.8 L355.5,514.6 L360.7,515.0 L370.3,522.7 L373.8,529.6 L375.6,541.1 L360.2,559.2 L366.0,589.0 L379.3,605.7 L394.6,609.5 L386.9,634.1 L383.5,632.2 L373.1,633.0 L359.9,626.7 L338.8,621.6 L305.7,623.0 L299.4,625.7 L299.6,620.5 L296.2,617.0 L296.1,614.0 L302.0,611.0 L303.4,605.5 L305.7,606.9 L308.7,600.7 L308.1,597.9 L318.9,593.2 L316.5,590.0 L317.3,588.4 L320.8,588.6 L320.8,585.4 L323.5,584.6 L324.3,576.7 L328.2,576.7 L327.3,573.9 L329.1,572.4 L325.6,567.7 L327.7,562.1 L325.9,559.6 L328.9,553.5 L328.8,548.7 L333.1,546.4 L330.0,542.2 L331.9,543.7 Z"},
};
const ASU_D = "M367.5,484.8 L364.5,482.6 L362.4,476.5 L368.4,472.4 L371.4,478.6 L367.5,484.8 Z"; /* distrito capital, no interactivo */

const BRANCHES = [
 {id:"matriz",     nombre:"Casa Matriz",  ciudad:"Hernandarias",           dept:"altoparana", dir:"Supercarretera Km 2,5",                              ruta:"SUPERCARRETERA · KM 2,5",       matriz:true, x:560.6,y:484.6},
 {id:"bellavista", nombre:"Bella Vista",  ciudad:"Bella Vista",            dept:"itapua",     dir:"Ruta PY 06 Km 51",                                   ruta:"RUTA PY 06 · KM 51",            x:504.5,y:605.4},
 {id:"campo9",     nombre:"Campo 9",      ciudad:"Dr. Juan Manuel Frutos", dept:"caaguazu",   dir:"Ruta PY 02 Km 207, Calle 6",                         ruta:"RUTA PY 02 · KM 207",           x:486.9,y:483.1},
 {id:"katuete",    nombre:"Katueté",      ciudad:"Katueté",                dept:"canindeyu",  dir:"Super Carretera 40, Avda. Las Residentes 1442",      ruta:"AVDA. LAS RESIDENTES 1442",     x:559.2,y:399.9},
 {id:"lomaplata",  nombre:"Loma Plata",   ciudad:"Loma Plata",             dept:"boqueron",   dir:"Acceso L P, Reiland",                                ruta:"ACCESO LOMA PLATA · REILAND",   x:215.9,y:262.2},
 {id:"rioverde",   nombre:"Río Verde",    ciudad:"Colonia Río Verde",      dept:"sanpedro",   dir:"Ruta PY 08 Dr. Blas Garay Km 342,5",                 ruta:"RUTA PY 08 · KM 342,5",         x:448.4,y:363.1},
 {id:"sanalberto", nombre:"San Alberto",  ciudad:"San Alberto",            dept:"altoparana", dir:"Ruta PY 07 Km 92",                                   ruta:"RUTA PY 07 · KM 92",            x:549.8,y:452.9},
 {id:"santarita",  nombre:"Santa Rita",   ciudad:"Santa Rita",             dept:"altoparana", dir:"Ruta PY 06 Km 206",                                  ruta:"RUTA PY 06 · KM 206",           x:537.6,y:513.3},
];
  const branchesOf = d => BRANCHES.filter(b => b.dept === d);
  const ACTIVE = [...new Set(BRANCHES.map(b => b.dept))];
  const NS = "http://www.w3.org/2000/svg";
  const svg = document.getElementById("mapa");
  const el = (t,at={}) => { const e = document.createElementNS(NS,t); for(const k in at) e.setAttribute(k,at[k]); return e; };

  const NEAREST = {
   concepcion:"rioverde", amambay:"katuete", presidentehayes:"lomaplata",
   altoparaguay:"lomaplata", cordillera:"campo9", central:"campo9",
   guaira:"campo9", paraguari:"campo9", caazapa:"santarita",
   misiones:"bellavista", neembucu:"bellavista",
  };
  const defs = el("defs");
  defs.innerHTML = `<linearGradient id="gradSel" x1="0" y1="0" x2="1" y2="1">
    <stop offset="0%" stop-color="#243f8f"/><stop offset="100%" stop-color="#0e1e50"/>
  </linearGradient>`;
  svg.appendChild(defs);

  /* etiquetas geográficas de fondo */
  [["BOLIVIA",100,96,-40],["ARGENTINA",150,505,24],["BRASIL",604,300,90]].forEach(([t,x,y,r])=>{
    const e = el("text",{x,y,class:"geo-label","font-size":"10.5","text-anchor":"middle",transform:`rotate(${r} ${x} ${y})`});
    e.textContent = t; svg.appendChild(e);
  });
  const chaco = el("text",{x:195,y:208,class:"geo-label","font-size":"25","text-anchor":"middle"});
  chaco.textContent = "CHACO";

  /* departamentos */
  const gd = el("g"); svg.appendChild(gd);
  for (const [id,d] of Object.entries(DEPTS)){
    const p = el("path",{
      d: d.d,
      class: "dep" + (ACTIVE.includes(id) ? " has" : ""),
      "data-id": id, tabindex:"0", role:"button",
      "aria-label": d.n + " — " + (branchesOf(id).length ? branchesOf(id).length + " sucursal(es) CIABAY" : "sin sucursal") + ". Clic para ver en la tabla",
    });
    gd.appendChild(p);
  }
  svg.appendChild(chaco);

  /* distrito capital + Asunción de referencia */
  svg.appendChild(el("path",{d:ASU_D,fill:"#e2e5eb",stroke:"#fff","stroke-width":"1.3","pointer-events":"none"}));
  svg.appendChild(el("circle",{cx:364.9,cy:475.8,r:3,fill:"#16368e",opacity:.9,"pointer-events":"none"}));
  const asu = el("text",{x:355.9,y:479.3,class:"asu-label","text-anchor":"end"}); asu.textContent = "Asunción"; svg.appendChild(asu);

  /* etiquetas de departamentos */
  for (const [id,d] of Object.entries(DEPTS)){
    const cnt = branchesOf(id).length;
    const y0 = cnt ? d.ly - 6 : d.ly;
    const e = el("text",{x:d.lx,y:y0,class:"dep-label" + (cnt ? " act" : ""),"data-id":id,"text-anchor":"middle"});
    const t1 = el("tspan",{x:d.lx,dy:0}); t1.textContent = d.lbl; e.appendChild(t1);
    if (cnt){ const t2 = el("tspan",{x:d.lx,dy:15,class:"num"}); t2.textContent = cnt; e.appendChild(t2); }
    svg.appendChild(e);
  }

  /* pines */
  const gp = el("g"); svg.appendChild(gp);
  BRANCHES.forEach(b=>{
    const g = el("g",{class:"pin" + (b.matriz?" mz":""), "data-id":b.id, "data-dep":b.dept});
    g.appendChild(el("circle",{cx:b.x,cy:b.y,r:11,class:"halo"}));
    g.appendChild(el("circle",{cx:b.x,cy:b.y,r:6.5,class:"core"}));
    gp.appendChild(g);
  });

  /* tooltip */
  const tip = document.getElementById("tipmap");
  svg.addEventListener("mousemove", e=>{
    const pin = e.target.closest(".pin");
    const dep = e.target.closest(".dep");
    if (pin){
      const b = BRANCHES.find(x=>x.id===pin.dataset.id);
      tip.innerHTML = `${b.nombre}${b.matriz?" · Casa Matriz":""}<small>${b.dir}</small>`;
    } else if (dep){
      const id = dep.dataset.id, n = branchesOf(id).length;
      tip.innerHTML = `${DEPTS[id].n}<small>${n ? n + (n>1?" SUCURSALES":" SUCURSAL") + " CIABAY · CLIC PARA VER" : "SIN SUCURSAL · CLIC PARA VER LA MÁS CERCANA"}</small>`;
    } else { tip.classList.remove("show"); return; }
    tip.style.left = e.clientX+"px"; tip.style.top = e.clientY+"px"; tip.classList.add("show");
  });
  svg.addEventListener("mouseleave", ()=>tip.classList.remove("show"));

  /* ============ SELECCIÓN: clic en departamento -> filtra la tabla ============ */
  let selected = null;
  const ORDER = ["matriz","sanalberto","santarita","katuete","campo9","rioverde","bellavista","lomaplata"];
  const listEl = document.getElementById("suclist");
  const mapk = document.getElementById("mapk");
  const resetBtn = document.getElementById("sucreset");

  function mkRow(b){
    const row = document.createElement("div");
    row.className = "suc-row" + (b.matriz?" mz":"");
    row.dataset.dep = b.dept;
    row.innerHTML = `<span class="suc-dot"></span><span class="suc-name">${b.nombre}${b.matriz?"<small>★ MATRIZ</small>":""}</span><span class="suc-city">${b.ciudad} · ${DEPTS[b.dept].lbl}</span>`;
    row.addEventListener("mouseenter", ()=>{ svg.querySelectorAll(`.dep[data-id="${b.dept}"]`).forEach(p=>p.classList.add("hl")); });
    row.addEventListener("mouseleave", ()=>{ svg.querySelectorAll(".dep.hl").forEach(p=>p.classList.remove("hl")); });
    return row;
  }

  function renderMap(){
    svg.classList.toggle("focus", !!selected);
    svg.querySelectorAll(".dep").forEach(p=>{
      p.classList.toggle("on", p.dataset.id===selected);
      p.setAttribute("aria-pressed", p.dataset.id===selected ? "true" : "false");
    });
    svg.querySelectorAll(".pin").forEach(p=>p.classList.toggle("on", p.dataset.dep===selected));
    svg.querySelectorAll(".dep-label").forEach(l=>l.classList.toggle("on", l.dataset.id===selected));
  }

  function renderList(){
    listEl.innerHTML = "";
    if (!selected){
      mapk.textContent = "Red CIABAY · 8 puntos";
      ORDER.forEach(id=>listEl.appendChild(mkRow(BRANCHES.find(x=>x.id===id))));
    } else {
      const ids = ORDER.filter(id => BRANCHES.find(x=>x.id===id).dept === selected);
      if (ids.length){
        mapk.textContent = DEPTS[selected].n + " · " + ids.length + (ids.length>1?" sucursales":" sucursal");
        ids.forEach(id=>listEl.appendChild(mkRow(BRANCHES.find(x=>x.id===id))));
      } else {
        const near = BRANCHES.find(b => b.id === NEAREST[selected]);
        mapk.textContent = DEPTS[selected].n + " · sin sucursal propia";
        const d = document.createElement("div");
        d.className = "suc-empty";
        d.innerHTML = `Aún sin sucursal en <b>${DEPTS[selected].n}</b>. Igual te atendemos: la más cercana es <b>${near.nombre}</b> (${near.ciudad} · ${DEPTS[near.dept].n}).`;
        listEl.appendChild(d);
        listEl.appendChild(mkRow(near));
      }
    }
    resetBtn.classList.toggle("show", !!selected);
  }

  function select(id){
    selected = (selected === id) ? null : id;
    renderMap(); renderList();
    if (selected && window.matchMedia("(max-width:979px)").matches){
      const smooth = window.matchMedia("(prefers-reduced-motion: reduce)").matches ? "auto" : "smooth";
      mapk.scrollIntoView({behavior:smooth, block:"center"});
    }
  }

  svg.addEventListener("click", e=>{
    const pin = e.target.closest(".pin");
    const dep = e.target.closest(".dep");
    if (pin) select(pin.dataset.dep);
    else if (dep) select(dep.dataset.id);
  });
  svg.addEventListener("keydown", e=>{
    if ((e.key==="Enter"||e.key===" ") && e.target.classList.contains("dep")){ e.preventDefault(); select(e.target.dataset.id); }
  });
  resetBtn.addEventListener("click", ()=>{ selected = null; renderMap(); renderList(); });

  renderList();

  /* Animaciones de entrada */
  var reduce=window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  var revs=document.querySelectorAll('.rev');
  if(reduce || !('IntersectionObserver' in window)){
    revs.forEach(function(el){el.classList.add('in');});
  }else{
    var io=new IntersectionObserver(function(entries){
      entries.forEach(function(en){
        if(en.isIntersecting){en.target.classList.add('in');io.unobserve(en.target);}
      });
    },{threshold:.12,rootMargin:'0px 0px -40px 0px'});
    revs.forEach(function(el){io.observe(el);});
  }
})();
})();
