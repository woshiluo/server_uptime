# Server Uptime

![Author](https://img.shields.io/badge/author-woshiluo-blue.svg)

> 简洁易搭建的 Server 在线检测

## 介绍

> Demo: [https://api.woshiluo.site/status](https://api.woshiluo.site/status)

本程序基于 `PHP` 和 `crontab`

这也说明，你需要一个网页服务器和一台 `Linux` 机子才可以正常运行

当然，你也可以使用别的定时运行工具，但我们并不保证其稳定性

## 已知缺点

> 这些缺点本来就属于设计的一部分，所以可能并不会很快的修复

- 性能一般，无法承受过多的网站
- 仅支持基于 HTTP Code 的探测（有计划修改）

## 搭建

- `/opt` 代表您的安装目录，请自行替换
- `example.com` 代表您的网站访问地址
 - 允许 IP
 - 允许 带有目录
 - 请自行补充 `http://` 或 `https://`

### Server 端

#### 需要

- 开启 `.htacess` 的 Apache2
 - 实际上可以不用，但你需要编写配置文件确保 `config.json` 及 `/server/` 目录下的 `*.json` 文件不会被访问到
- PHP 环境
- crontab 正常运行

#### 下载和配置

下载本项目的 `server` 文件夹到 `/opt/server`

请配置您的 Web 服务器，确保 `/opt/server` 可以被 `example.com` 访问到

配置 `config.json`

```json
{
	"auth_code" : {
		"Group": "Group_Name",
		"Name": "Client_Name"
	}
}
```

其中
- `auth_code` 表示网站标识符，请注意不能冲突，建议使用 `UUID`
- `Group_Name` 表示网站所在组的名称，同一名称自动分到一组
- `Client_Name` 代表网站的名称
- 以上项均不可以出现中文

你可以通过添加你多个 `auth_code` 项来监控多个网站

在配置完后，执行

```bash
php /opt/server/init.php
```

#### crontab 相关

```bash
sudo crontab -e
```

在最后一行添加

```bash
0 0 * * * (/usr/bin/php /opt/server/update.php)
```

### Client 端

#### 需要

- PHP 环境
- `php-curl` 支持
- crontab 支持

#### 下载及配置

下载本项目的 `client` 文件夹到 `/opt/client`

如果有，请配置您的 Web 服务器，确保 `/opt/client` 无法访问到

```json
[
	{
		"type": 0,
		"uuid": "uuid"
	},
	{
		"type": 1,
		"uuid": "uuid",
		"address": "adress"
	}
]
```

- `type` 表示探测模式
 - `0` 表示直接向服务器发送存活
 - `1` 表示先探测，然后想服务器发送 HTTP Code
- `uuid` 表示这个服务在 Server 端对应的 uuid 码
- `address` 监听的网址

#### crontab 配置

```bash
*/5 * * * * (/usr/bin/php /opt/client/index.php)
```

##  FAQ

> Q: 在，为什么使用 PHP

A： 实际上本来想用 Node.js / Golang 的，但是因为时间紧张，没有时间去熟练别的语言，刚好 PHP 熟练，就拉过来用了

> Q: 有一些同类项目，功能什么的都比较齐全，为什么要重新造轮子

A:
1. 我懒得搭 Python 等新环境环境
2. 功能过多，UI 魔改难度大于重写
3. 一定程度上也算是实践向作品，你可以理解为一个菜鸡的自我练手拿出来丢人
4. 我一定程度上需要内网服务监控，大多数监控平台并不支持

##  声明及致谢

本项目在开发途中使用了以下开源项目，在此表示感谢

- [MDUI](https://github.com/zdhxiong/mdui)

欢迎各位大爷们提出 `issue` `Pull Requet`，求大佬们轻喷
