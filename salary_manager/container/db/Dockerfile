# ベースイメージの指定
FROM mysql:8.0

# 作成した設定ファイルをコンテナ内にコピー
COPY ./container/db/my.conf /etc/my.conf

RUN groupmod -g 1000 mysql && usermod -u 1000 -g 1000 mysql