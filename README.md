
Arduino Mini Project - 2.0 - 데이터 시각화
===================
의도(개발 계기)
----------
* arduino 1.0에서 확장, 개선
  * https://github.com/juhye963/arduino-1.0
* 1.0의 결과를 외부에서도 확인할 수 있도록 운영서버에 올리고자 함
* 표에서 더 나아가 그래프를 통한 시각화
  * 외부에서 실내의 온도를 파악할 수 있도록 한다.
***

변경사항
------
* 그래프를 통해 변화를 시각화하고 일상에서 유용하게 사용할 수 있는 IoT 장비로서의 확장을 생각했을 때 온도 센서가 더 적절하다 생각하여 변경
* 웹을 통한 시각화로 충분하다 생각하여 LCD를 빼고 회로구성을 다시 하였다.

***
개발환경
-------
* **로컬**
  * Window 7
  * 아나콘다(python)
  * mysql 5.7 (workbench)
  * XAMPP
  * git bash
* **운영(AWS EC2)**
  * Ubuntu 18.04.3 LTS
  * PHP Version 7.2.24-0ubuntu0.18.04.3
  * Apache/2.4.29 (Ubuntu)
  * mysql Ver 14.14 Distrib 5.7.29, for Linux (x86_64) using EditLine wrapper

***

개발과정 : 2020.03.02~2020.03.04 (작업 기간 : 3일)
--------
> ### Step 1 : AWS EC2 환경 세팅 및 DB 연결
* **arduino 1.0을 로컬단계에서 발전시키기 위해 어떤 방향으로 가야 할지 연구 시작**
  * 키워드 : AWS 웹서버 구축, EC2 데이터베이스, AWS arduino, IoT 자료수집 시각화 분석, AWS IoT (아두이노, 라즈베리 파이 연동)
* **아두이노의 데이터를 보내는 두 가지 방안 떠오름**
  1. usb로 연결한 아두이노를 EC2가 인식하도록 하는 방안(usb over ip)
  2. 파이선으로 받은 데이터를 로컬 DB가 아닌 EC2의 DB에 저장하도록 하는 방안
* **최종적으로 2번으로 작동하는 방법을 찾아 채택하였다.**

* ![image](https://user-images.githubusercontent.com/59054012/76735036-79453700-67a7-11ea-8297-2c49a3e18104.png)


* **EC2 인스턴스 구축과정과 외부에서 DB에 접근할 수 있도록 하는 방법은 블로그에 포스팅하였다.**
  * (포스팅용으로 인스턴스를 다시 만들어서 캡처했으므로 실제 운영서버와 약간 차이가 있다.)
  * https://juju-coding.tistory.com/19
  * https://juju-coding.tistory.com/28

***

> ### Step 2 : 운영서버 구축 및 정보시스템 이관
* **apache 서버를 구축**
  * https://juju-coding.tistory.com/25
* **git bash를 이용하여 로컬의 파일을 EC2로 옮긴다.**

* ![image](https://user-images.githubusercontent.com/59054012/76734807-08058400-67a7-11ea-99d1-7c972b12d394.png)

* **시스템 이관했을 때 PHP 코드를 인식하지 못하는 문제 당면**
  * PHP를 설치하거나 apache 설정 파일을 수정하면 된다. 블로그에 자세히 포스팅해놓았다.
  * https://juju-coding.tistory.com/26

***

> ### Step 3 : 시각화 (그래프와 표)
* googleChart 이용하여 그래프로 시각화
  * pchart, jqplot도 시도.
  * jqplot나 pchart를 선택하지 않은 이유 : x축을 시간으로 하고 db의 시간 데이터를 가져오고 싶었으나 잘되지 않았다.

* ![image](https://user-images.githubusercontent.com/59054012/76735941-4dc34c00-67a9-11ea-908f-ce2ad4a4fece.png)

* ![image](https://user-images.githubusercontent.com/59054012/76736901-15bd0880-67ab-11ea-953a-3e16f3e3291c.png)

* 데이터가 많이 쌓여 페이징 처리를 추가해주었다.

***

마무리
--------
* **데이터양이 많아지면서 생겨나는 outlier들의 처리가 아쉽다.**
  * R 등의 데이터 분석 도구를 이용하면 가능
  * 실시간으로 시각화할 수 있게 하면서 처리를 하려면 어떻게 해야 할까?
* **데이터양이 많은데 그냥 다 가져와서 시각화해버린 것이 아쉽다.**
  * 시간, 일, 주별 그래프나 평균을 볼 수 있다면 좋을 것 같다.
* **결과물을 어떻게 더 잘 활용할 수 있을까?**
  * 약 일주일간 데이터를 쌓아두니 히터 전원에 따라 약 18도에서 25도를 오가는 패턴이 보인다.
  * 이 패턴을 어떻게 활용할 수 있을까?
  * 히터가 꺼지면 사람이 없다는 뜻. 즉 온도가 낮아지면 사람이 없다는 뜻이다.
  * 주변 피드백을 받다가 Wake On Lan(WOL)이라는 기능을 알게 됨. 나중에 추가해보면 좋을 듯하다.
