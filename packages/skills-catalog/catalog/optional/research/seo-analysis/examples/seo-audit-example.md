# SEO Audit Example: E-commerce Site

## Input Request

```
Perform an SEO audit of https://example-store.com focusing on:
- Technical health and page speed
- Product page optimization
- Blog content strategy
- Recommendations for improving rankings for "handmade leather wallets"
```

## Analysis Process

### Step 1: Site Inventory

**Pages Categorized:**
- Home page (1)
- Category pages (8: wallets, belts, bags, etc.)
- Product pages (45 individual products)
- Blog posts (12 articles)
- Static pages (About, Contact, FAQ, Shipping)

**Total Indexed Pages:** ~67

### Step 2: Technical Audit Results

| Metric | Score | Status |
|--------|-------|--------|
| Mobile Usability | 78/100 | ⚠️ Needs Work |
| Page Speed (Desktop) | 65/100 | ⚠️ Needs Work |
| Page Speed (Mobile) | 52/100 | ❌ Poor |
| HTTPS | 100/100 | ✅ Good |
| XML Sitemap | 100/100 | ✅ Good |
| Robots.txt | 100/100 | ✅ Good |

**Critical Issues Found:**
1. Images not optimized (average file size 2.3MB, should be <500KB)
2. No lazy loading implemented
3. Render-blocking JavaScript on product pages
4. Missing alt text on 23 product images
5. H1 tag missing on 12 product pages

### Step 3: On-Page Analysis

**Title Tags:**
- 8 pages have titles >60 characters (truncated in SERPs)
- 5 pages have duplicate titles
- 3 product pages missing titles entirely

**Meta Descriptions:**
- 34 pages missing meta descriptions
- 12 descriptions are auto-generated from content

**Header Structure:**
- All pages have H1 (good)
- 15 pages have multiple H1 tags (issue)
- Inconsistent H2/H3 usage across category pages

**Content Quality:**
- Product descriptions average 85 words (too thin, recommend 200+)
- 8 product pages have duplicate manufacturer descriptions
- Blog content is high quality but infrequent (1 post/month)

### Step 4: Keyword Analysis

**Target Keyword: "handmade leather wallets"**

| Page | Current Ranking | Search Volume | Competition |
|------|-----------------|---------------|-------------|
| Home | Not ranking | 2,400/mo | High |
| /category/wallets | Position 28 | 2,400/mo | High |
| /product/artisan-wallet | Position 45 | 880/mo | Medium |

**Content Gaps Identified:**
- No content about "how to care for leather wallets"
- Missing comparison content ("genuine vs full-grain leather")
- No buying guide for leather wallets

### Step 5: Competitive Analysis

**Top Competitors for Target Keyword:**

1. **CraftLeather.com** (Rank 1)
   - Content depth: 2,500 word buying guide
   - Backlinks: 340 referring domains
   - Page speed: 92/100

2. **ArtisanWallets.co** (Rank 3)
   - Content depth: Detailed product specs
   - Backlinks: 180 referring domains
   - Page speed: 88/100

3. **LeatherGoodsDirect.com** (Rank 5)
   - Content depth: Video content + guides
   - Backlinks: 220 referring domains
   - Page speed: 95/100

## Recommendations

### Quick Wins (1-2 weeks)

1. **Add alt text to all product images**
   - Format: "Handmade [color] leather wallet - [brand name]"
   - Impact: Accessibility + image search traffic

2. **Fix missing H1 tags on 12 product pages**
   - Use format: "[Product Name] - Handmade Leather Wallet"
   - Impact: Better page structure for crawlers

3. **Compress product images**
   - Target: <500KB per image
   - Use WebP format with JPEG fallback
   - Impact: Mobile speed score +25 points

4. **Add meta descriptions to 34 pages**
   - Include primary keyword naturally
   - Keep under 160 characters
   - Impact: Improved CTR from SERPs

### Medium Priority (1-2 months)

1. **Expand product descriptions**
   - Target: 200-300 words per product
   - Include: materials, dimensions, care instructions
   - Impact: Better content depth, reduced bounce rate

2. **Create leather care content**
   - Article: "How to Clean and Condition Your Leather Wallet"
   - Target keywords: "leather wallet care", "condition leather wallet"
   - Impact: Informational traffic + authority building

3. **Implement lazy loading**
   - Below-fold images load on scroll
   - Impact: Initial page load -3 seconds

### Long-term Strategy (3-6 months)

1. **Build comprehensive buying guide**
   - 2,500+ words covering all wallet types
   - Include comparison tables, care tips, sizing guide
   - Target: "handmade leather wallets" primary keyword

2. **Develop content calendar**
   - 2 blog posts per month
   - Topics: leather types, care guides, style tips
   - Impact: Consistent organic traffic growth

3. **Build backlink profile**
   - Outreach to leather craft blogs
   - Guest posts on fashion/accessory sites
   - Target: 50 new referring domains

## Expected Outcomes

| Metric | Current | 3-Month Target | 6-Month Target |
|--------|---------|----------------|----------------|
| Organic Traffic | 1,200/mo | 2,500/mo | 5,000/mo |
| Avg. Position (target KW) | 45 | 25 | 12 |
| Mobile Speed Score | 52 | 75 | 90 |
| Pages with Issues | 34 | 10 | 0 |

## Implementation Notes

- Track progress using Google Search Console
- Set up rank tracking for 10 primary keywords
- Monitor Core Web Vitals monthly
- Review and update content quarterly
