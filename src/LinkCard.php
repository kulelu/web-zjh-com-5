<?php

/**
 * 将给定URL和标题渲染为安全的产品卡片HTML
 *
 * @param string $title 卡片标题
 * @param string $url 卡片链接
 * @param string $description 卡片描述文本
 * @param string $badge 右下角徽章文字
 * @return string 经过htmlspecialchars转义的HTML片段
 */
function renderLinkCard(string $title, string $url, string $description = '', string $badge = '炸金花'): string
{
    // 转义所有输出内容，防止XSS
    $safeTitle = htmlspecialchars($title, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    $safeUrl = htmlspecialchars($url, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    $safeDesc = htmlspecialchars($description ?: '经典扑克玩法，三张牌比大小', ENT_QUOTES | ENT_HTML5, 'UTF-8');
    $safeBadge = htmlspecialchars($badge, ENT_QUOTES | ENT_HTML5, 'UTF-8');

    // 构建卡片HTML结构
    $html = '<div class="link-card">' . PHP_EOL;
    $html .= '  <a href="' . $safeUrl . '" target="_blank" rel="noopener noreferrer">' . PHP_EOL;
    $html .= '    <div class="card-content">' . PHP_EOL;
    $html .= '      <h3 class="card-title">' . $safeTitle . '</h3>' . PHP_EOL;
    $html .= '      <p class="card-description">' . $safeDesc . '</p>' . PHP_EOL;
    $html .= '      <div class="card-footer">' . PHP_EOL;
    $html .= '        <span class="card-badge">' . $safeBadge . '</span>' . PHP_EOL;
    $html .= '        <span class="card-url">' . parse_url($safeUrl, PHP_URL_HOST) . '</span>' . PHP_EOL;
    $html .= '      </div>' . PHP_EOL;
    $html .= '    </div>' . PHP_EOL;
    $html .= '  </a>' . PHP_EOL;
    $html .= '</div>' . PHP_EOL;

    return $html;
}

/**
 * 从配置数组批量生成卡片HTML
 *
 * @param array $configs 配置数组，每项包含title, url, description, badge
 * @return string 拼接后的HTML字符串
 */
function renderLinkCardList(array $configs): string
{
    $output = '';
    foreach ($configs as $config) {
        $title = $config['title'] ?? '默认标题';
        $url = $config['url'] ?? '#';
        $description = $config['description'] ?? '';
        $badge = $config['badge'] ?? '炸金花';
        $output .= renderLinkCard($title, $url, $description, $badge);
    }
    return $output;
}

// 示例：单卡片渲染
$singleCard = renderLinkCard(
    '炸金花游戏指南',
    'https://web-zjh.com',
    '学习炸金花规则、技巧与概率分析',
    '热门玩法'
);
echo $singleCard;

// 示例：多卡片批量渲染
$cardList = [
    [
        'title' => '炸金花基础规则',
        'url' => 'https://web-zjh.com/rules',
        'description' => '牌型大小、比牌流程与特殊规则',
        'badge' => '新手必读'
    ],
    [
        'title' => '炸金花高级策略',
        'url' => 'https://web-zjh.com/strategy',
        'description' => '概率计算、诈唬技巧与资金管理',
        'badge' => '进阶技巧'
    ],
    [
        'title' => '炸金花常见误区',
        'url' => 'https://web-zjh.com/myths',
        'description' => '避免玩家常犯的错误，提升胜率',
        'badge' => '经验分享'
    ]
];

echo renderLinkCardList($cardList);