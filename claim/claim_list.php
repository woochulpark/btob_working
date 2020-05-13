<?
		if(!isset($_GET['ind'])){
			$_GET['ind'] = 0;
		}
		echo "<!--".$_GET['ind']."-->";
		switch($_GET['ind']){
			case '1':
?>
		<div class="dbins content">
                    <h3>01. 보험금 청구 및 지급 프로세스</h3>
                    <ul class="list_type01">
                        <li>① 해당 구비서류 준비</li>
                        <li>② 이메일 또는 팩스 전송</li>
                        <li>③ 보상과 접수 진행</li>
                        <li>④ 서류 심사</li>
                        <li>⑤ 보상</li>
                    </ul>
                    <h3>02. 보험금 청구 서류</h3>
                    <h4>※ 의료비 청구일 경우</h4>
                    <ul class="list_type01">
                        <li>① 보험금 청구서<a href="/doc/DB_insurance_claim.pdf" class="btn_download" target="_blank">다운로드</a></li>
                        <li>① 사고 경위서<a href="/doc/DB_accident_history.pdf" class="btn_download" target="_blank">다운로드</a></li>
                        <li>② 피보험자 여권 사본</li>
                        <li>③ 출입국 사실 증명서(민원24에서 발급 가능) 혹은 여권에 찍힌 출입국 스탬프 사본</li>
                        <li>④ 피보험자 통장 사본(피보험자가 미성년자일 경우 부모님 통장과 함께 가족관계 확인서 또는 등본 첨부)</li>
                        <li>⑤ 손해 입증자료
                            <ul class="depth3">
                                <li>귀국 전일 경우 → 해당 병원 기록지, 병원 영수증(카드 결제 시 카드 내역 조회도 같이 보내주시면 보다 정확한 금액 산정이 가능)</li>
                                <li>귀국 후 국내 “통원”진료 → 초진 기록지(해외에서 발병했다는 사실 기재), 병원 영수증, 진료비 상세 내역서, 약제비 영수증</li>
                                <li>귀국 후 국내 “입원”진료 → 통원진료 필요서류 + 진단명 확인되는 입퇴확인서 </li>
                                <li>미성년자일 경우 → 보호자 신분증, 통장사본, 가족관계증명서 혹은 등본</li>
                            </ul>
                        </li>   
                    </ul>
                    <h4>※ 휴대품 청구일 경우(파손과 도난 2가지로 분류)</h4>
                    <ul class="list_type01">
                        <li><span>① 파손일 경우</span>
                            <ul class="depth3">
                                <li>보험금 청구서<a href="/doc/DB_insurance_claim.pdf" class="btn_download" target="_blank">다운로드</a></li>
                                <li>사고 경위서<a href="/doc/DB_accident_history.pdf" class="btn_download" target="_blank">다운로드</a></li>
                                <li>목격자 확인서<a href="/doc/DB_eye_confirm.pdf" class="btn_download" target="_blank">다운로드</a><span>(목격자가 없을 경우 보험금 청구서 사고 내용에 반드시 “목격자 없음” 이라고 작성 해주셔야 됩니다.)</span></li>
                                <li>피보험자 여권 사본</li>
                                <li>출입국 사실 증명서(민원24에서 발급 가능) 혹은 여권에 찍힌 출입국 스탬프 사본</li>
                                <li>피보험자 통장 사본(피보험자가 미성년자일 경우 부모님 통장과 함께 가족관계 확인서 또는 등본 첨부)</li>
                                <li>손해 입증자료
                                    <ul class="depth4">
                                        <li>- 수리가 가능한 경우 → 수리 영수증 및 견적서</li>
                                        <li>- 수리가 불가능한 경우 → 수리 불가 확인서</li>
                                        <li class="indent">* 수리 불가 확인서 양식이 없을 시 → 견적서에 수리 불가능한 사유 간단히 작성 후 업체 직인 또는 담당 엔지니어 명함 첨부</li>
                                        <li>- 수리해야 될 물품이 핸드폰일 경우에는 → 통신사 확인서 필요(통신사 고객센터 또는 홈페이지에서 발급 가능합니다.)</li>
                                        <li class="indent">* SK인 경우 → 이용계약 등록사항 증명서</li>
                                        <li class="indent">* KT인 경우 → 원부 증명서</li>
                                        <li class="indent">* LG인 경우 → 가입 사실 확인서</li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li><span>② 도난일 경우</span>
                            <ul class="depth3">
                                <li>보험금 청구서<a href="/doc/DB_insurance_claim.pdf" class="btn_download" target="_blank">다운로드</a></li>
                                <li>목격자 확인서<a href="/doc/DB_eye_confirm.pdf" class="btn_download" target="_blank">다운로드</a><span>(목격자가 없을 경우 보험금 청구서 사고 내용에 반드시 “목격자 없음”이라고 작성해 주셔야 됩니다.)</span></li>
                                <li>피보험자 여권 사본</li>
                                <li>출입국 사실 증명서(민원24에서 발급 가능) 혹은 여권에 찍힌 출입국 스탬프 사본</li>
                                <li>피보험자 통장 사본(피보험자가 미성년자일 경우 부모님 통장과 함께 가족관계 확인서 또는 등본 첨부)</li>
                                <li>폴리스 리포트
                                    <ul class="depth4">
                                        <li>- 현지 경찰서 갔을 경우 → 폴리스 리포트 제출</li>
                                        <li>- 국내 경찰서 갔을 경우 → 가까운 경찰서 방문 후 민원실에서 분실신고확인서 작성 후 제출</li>
                                    </ul>
                                </li>
                                <li>도난 물품 리스트 및 영수증
                                    <ul class="depth4">
                                        <li>- 도난 된 물품명, 구입 시기 당시 금액, 구입 시기 년, 월, 구입 장소를 반드시 기재해야 되며 영수증이 없을 경우 보험금 청구서 사고 내용에 “영수증 없음”이라고 작성</li>
                                        <li>- 피해 물품이 휴대폰인 경우 → 통신사 확인서 필요(통신사 고객센터 또는 홈페이지에서 발급 가능합니다)</li>
                                        <li class="indent">* SK인 경우 → 이용계약 등록사항 증명서</li>
                                        <li class="indent">* KT인 경우 → 원부 증명서</li>
                                        <li class="indent">* LG인 경우 → 가입 사실 확인서</li>
                                    </ul>
                                </li>
                            </ul>
                        </li>  
                    </ul>
                </div>
<?
	break;
	case '0':
?>
		<div class="aceins content">
                    <h3>01. 보험금 청구 및 지급 프로세스</h3>
                    <ul class="list_type01">
                        <li>① 해당 구비서류 준비</li>
                        <li>② 이메일 또는 팩스 전송</li>
                        <li>③ 보상과 접수 진행</li>
                        <li>④ 서류 심사</li>
                        <li>⑤ 보상</li>
                    </ul>
                    <h3>02. 보험금 청구 서류</h3>
                    <h4>※ 의료비 청구일 경우</h4>
                    <ul class="list_type01">
                        <li>① 보험금 청구서<a href="/doc/CHUBB_insurance_claim.pdf"  class="btn_download" target="_blank">다운로드</a></li>
                        <li>② 피보험자 여권 사본</li>
                        <li>③ 출입국 사실 증명서(민원24에서 발급 가능) 혹은 여권에 찍힌 출입국 스탬프 사본</li>
                        <li>④ 피보험자 통장 사본(피보험자가 미성년자일 경우 부모님 통장과 함께 가족관계 확인서 또는 등본 첨부)</li>
                        <li>⑤ 손해 입증자료
                            <ul class="depth3">
                                <li>귀국 전일 경우 → 해당 병원 기록지, 병원 영수증(카드 결제 시 카드 내역 조회도 같이 보내주시면 보다 정확한 금액 산정이 가능)</li>
                                <li>귀국 후 국내 “통원”진료 → 초진 기록지(해외에서 발병했다는 사실 기재), 병원 영수증, 진료비 상세 내역서, 약제비 영수증</li>
                                <li>귀국 후 국내 “입원”진료 → 통원진료 필요서류 + 진단명 확인되는 입퇴확인서 </li>
                                <li>미성년자일 경우 → 보호자 신분증, 통장사본, 가족관계증명서 혹은 등본</li>
                            </ul>
                        </li>   
                    </ul>
                    <h4>※ 휴대품 청구일 경우(파손과 도난 2가지로 분류)</h4>
                    <ul class="list_type01">
                        <li>① 파손일 경우
                            <ul class="depth3">
                                <li>보험금 청구서<a href="/doc/CHUBB_insurance_claim.pdf"  class="btn_download" target="_blank">다운로드</a></li>
                                <li>목격자 확인서<a href="/doc/CHUBB_eye_confirm.pdf" class="btn_download" target="_blank">다운로드</a><span>(목격자가 없을 경우 보험금 청구서 사고 내용에 반드시 “목격자 없음”이라고 작성해 주셔야 됩니다.)</span></li>
                                <li>피보험자 여권 사본</li>
                                <li>출입국 사실 증명서(민원24에서 발급 가능) 혹은 여권에 찍힌 출입국 스탬프 사본</li>
                                <li>피보험자 통장 사본(피보험자가 미성년자일 경우 부모님 통장과 함께 가족관계 확인서 또는 등본 첨부)</li>
                                <li>손해 입증자료
                                    <ul class="depth4">
                                        <li>- 수리가 가능한 경우 → 수리 영수증 및 견적서</li>
                                        <li>- 수리가 불가능한 경우 → 수리 불가 확인서</li>
                                        <li class="indent">* 수리 불가 확인서 양식이 없을 시 → 견적서에 수리 불가능한 사유 간단히 작성 후 업체 직인 또는 담당 엔지니어 명함 첨부</li>
                                        <li>- 수리해야 될 물품이 핸드폰일 경우에는 → 통신사 확인서 필요(통신사 고객센터 또는 홈페이지에서 발급 가능합니다.)</li>
                                        <li class="indent">* SK인 경우 → 이용계약 등록사항 증명서</li>
                                        <li class="indent">* KT인 경우 → 원부 증명서</li>
                                        <li class="indent">* LG인 경우 → 가입 사실 확인서</li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li>② 도난일 경우
                            <ul class="depth3">
                                <li>보험금 청구서<a href="/doc/CHUBB_insurance_claim.pdf"  class="btn_download" target="_blank">다운로드</a></li>
                                <li>목격자 확인서<a href="/doc/CHUBB_eye_confirm.pdf" class="btn_download" target="_blank">다운로드</a><span>(목격자가 없을 경우 보험금 청구서 사고 내용에 반드시 “목격자 없음”이라고 작성해 주셔야 됩니다.)</span></li>
                                <li>피보험자 여권 사본</li>
                                <li>출입국 사실 증명서(민원24에서 발급 가능) 혹은 여권에 찍힌 출입국 스탬프 사본</li>
                                <li>피보험자 통장 사본(피보험자가 미성년자일 경우 부모님 통장과 함께 가족관계 확인서 또는 등본 첨부)</li>
                                <li>폴리스 리포트
                                    <ul class="depth4">
                                        <li>- 현지 경찰서 갔을 경우 → 폴리스 리포트 제출</li>
                                        <li>- 국내 경찰서 갔을 경우 → 가까운 경찰서 방문 후 민원실에서 분실신고확인서 작성 후 제출</li>
                                    </ul>
                                </li>
                                <li>도난 물품 리스트 및 영수증
                                    <ul class="depth4">
                                        <li>- 도난 된 물품명, 구입 시기 당시 금액, 구입 시기 년, 월, 구입 장소를 반드시 기재해야 되며 영수증이 없을 경우 보험금 청구서 사고 내용에 “영수증 없음”이라고 작성</li>
                                        <li>- 피해 물품이 휴대폰인 경우 → 통신사 확인서 필요(통신사 고객센터 또는 홈페이지에서 발급 가능합니다)</li>
                                        <li class="indent">* SK인 경우 → 이용계약 등록사항 증명서</li>
                                        <li class="indent">* KT인 경우 → 원부 증명서</li>
                                        <li class="indent">* LG인 경우 → 가입 사실 확인서</li>
                                    </ul>
                                </li>
                            </ul>
                        </li>  
                    </ul>
                    <h4>※ 항공기 및 수화물 지연에 따른 추가 비용 청구일 경우</h4>
                    <ul class="list_type01">
                        <li>① 보험금 청구서<a href="/doc/CHUBB_insurance_claim.pdf"  class="btn_download" target="_blank">다운로드</a></li>
                        <li>② e-ticket </li>
                        <li>③ 피보험자 여권 사본</li>
                        <li>④ 출입국 사실 증명서(민원24에서 발급 가능) 혹은 여권에 찍힌 출입국 스탬프 사본</li>
                        <li>⑤ 항공사 지연 확인서</li>
                        <li>⑥ 피보험자 통장 사본(피보험자가 미성년자일 경우 부모님 통장과 함께 가족관계 확인서 또는 등본 첨부)</li>
                        <li>⑦ 손해 입증자료
                            <ul class="depth3">
                                <li>항공기 결항/항공기 지연/취소/과적에 의해 4시간 내에 대체(항공) 수단이 제공되지 못한 경우
                                    <ul class="depth4">
                                        <li>- 식사, 간식, 전화 통화 영수증, 숙박비, 숙박시설까지 이용한 교통비 영수증</li>
                                        <li>- 다른 항공편으로 출발한 경우 비상 의복 및 필수품 구입 비용 영수증(단 숙박이 필요한 경우에 한함)</li>
                                    </ul>
                                </li>
                                <li>수화물이 6시간 내에 도착하지 못한 경우
                                    <ul class="depth4">
                                        <li>- 비상 의복과 필수품 구입 비용 영수증</li>
                                    </ul>
                                </li>
                                <li>수화물이 24시간 내에 도착하지 못한 경우
                                    <ul class="depth4">
                                        <li>- 예정된 도착지에 도착 후 120시간 내에 발생한 의복과 필수품 등의 구입 비용 영수증</li>
                                    </ul>
                                </li>
                            </ul>
                        </li>  
                    </ul>
                </div>
<?
		break;
	
	}
?>