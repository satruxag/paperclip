---
name: seo-analysis
description: Perform technical SEO audits and optimization recommendations for websites — analyze on-page factors, content quality, meta tags, internal linking, page speed, and generate actionable improvement reports.
key: paperclipai/optional/research/seo-analysis
recommendedForRoles:
  - writer
  - product
  - engineer
tags:
  - seo
  - optimization
  - analysis
  - web
  - content
---

# SEO Analysis Skill

Perform comprehensive SEO audits and generate optimization recommendations for websites and web portals. This skill combines technical SEO best practices with content optimization strategies to improve search engine visibility and rankings.

## When to use

- You need to audit a website's current SEO health
- You want recommendations to improve page rankings
- You need to optimize content for specific keywords
- You want to analyze competitors' SEO strategies
- You need to generate SEO reports for stakeholders

## When not to use

- You need to actually implement code changes on a live site (use a development skill instead)
- You're doing non-web SEO (app store optimization, local business listings without web presence)
- You need real-time search ranking data (this skill provides analysis, not live SERP tracking)

## Core SEO Principles

### On-Page SEO

1. **Title Tags**: Each page must have a unique, descriptive title (50-60 characters)
2. **Meta Descriptions**: Compelling summaries (150-160 characters) that encourage clicks
3. **Header Structure**: Logical H1-H6 hierarchy with keywords naturally integrated
4. **Content Quality**: Original, valuable content that answers user queries
5. **Internal Linking**: Strategic links between related pages with descriptive anchor text
6. **Image Optimization**: Alt text for accessibility and SEO value
7. **URL Structure**: Clean, descriptive URLs without unnecessary parameters

### Technical SEO

1. **Page Speed**: Target Core Web Vitals scores above 90
2. **Mobile-First**: Fully responsive design with mobile usability
3. **SSL/HTTPS**: Secure connection mandatory for rankings
4. **XML Sitemap**: Updated sitemap submitted to search engines
5. **Robots.txt**: Proper crawl instructions
6. **Structured Data**: Schema markup for rich snippets
7. **Canonical Tags**: Prevent duplicate content issues

### Content Optimization

1. **Keyword Research**: Identify high-value, relevant search terms
2. **Keyword Density**: Natural usage (1-2% primary keyword)
3. **Content Length**: Comprehensive coverage (1000+ words for competitive topics)
4. **Readability**: Clear structure, short paragraphs, bullet points
5. **Freshness**: Regular content updates and additions

## Analysis Workflow

### Step 1: Site Crawl and Inventory

- Crawl the target website to map all pages
- Identify page types (home, category, product, blog, etc.)
- Catalog existing meta tags, headers, and content structure
- Note technical issues (broken links, missing alt text, etc.)

### Step 2: Technical Audit

- Check page load speeds (use PageSpeed Insights methodology)
- Verify mobile responsiveness across device sizes
- Validate HTTPS implementation and certificate validity
- Review XML sitemap completeness and robots.txt rules
- Check for duplicate content and canonical tag usage

### Step 3: On-Page Analysis

- Evaluate title tags and meta descriptions for each page
- Assess header hierarchy and keyword usage
- Review content quality and uniqueness
- Analyze internal linking structure and anchor text
- Check image optimization (alt text, file sizes, formats)

### Step 4: Competitive Analysis

- Identify top 3-5 competitors for target keywords
- Compare content depth and quality
- Analyze backlink profiles (if tools available)
- Note gaps and opportunities

### Step 5: Generate Recommendations

- Prioritize fixes by impact and effort
- Provide specific, actionable recommendations
- Include implementation examples where helpful
- Create a roadmap for improvements

## Output Format

Generate a structured SEO report with:

1. **Executive Summary**: High-level findings and priority actions
2. **Technical Health Score**: Numeric score with breakdown
3. **On-Page Issues**: Specific pages and fixes needed
4. **Content Opportunities**: Topics and keywords to target
5. **Quick Wins**: Low-effort, high-impact changes
6. **Long-term Strategy**: Comprehensive improvement plan

## Tools and Resources

This skill references established SEO frameworks:

- Google's Search Central documentation
- Core Web Vitals guidelines
- Schema.org markup standards
- Industry best practices from authoritative SEO sources

## Limitations

- Cannot access real-time search ranking data
- Cannot directly modify website content
- Analysis is based on publicly crawlable content
- Some advanced metrics require paid SEO tools (Ahrefs, SEMrush, etc.)

## Example Usage

```
Analyze the SEO health of https://example.com and provide:
1. A technical audit with scores
2. Top 10 issues to fix
3. Content recommendations for the blog section
4. A 90-day improvement roadmap
```

## Maintenance

This skill should be updated regularly to reflect:
- Search engine algorithm updates
- New SEO best practices
- Changes in Core Web Vitals metrics
- Emerging optimization techniques
